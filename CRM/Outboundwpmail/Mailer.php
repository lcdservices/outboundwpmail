<?php

use CRM_Outboundwpmail_ExtensionUtil as E;

class CRM_Outboundwpmail_Mailer {

  /**
   * Send an email
   */
  function send($recipients, $headers, $body) {
    /*Civi::log()->debug(__FUNCTION__, [
      'recipients' => $recipients,
      'headers' => $headers,
      'body' => $body,
    ]);*/

    //restructure headers
    $wpHeaders = $attachments = [];

    //check if this is multipart/mixed
    if (strpos($headers['Content-Type'], 'multipart/mixed') !== FALSE ||
      strpos($headers['Content-Type'], 'multipart/alternative') !== FALSE
    ) {
      //we need to parse the elements and include attachments separately
      $parsed = self::parseEmail($headers, $body);
      $body = $parsed['html'];
      $attachments = $parsed['attachments'];

      //set content-type to just html
      $headers['Content-Type'] = 'text/html; charset=utf-8';
    }

    foreach ($headers as $key => $header) {
      $wpHeaders[] = "{$key}: {$header}";
    }

    //Civi::log()->debug(__FUNCTION__, ['$wpHeaders' => $wpHeaders]);
    wp_mail($recipients, $headers['Subject'], $body, $wpHeaders, $attachments);

    //cleanup attachments directory
    if (!empty($parsed['attachmentsDir'])) {
      CRM_Utils_File::cleanDir($parsed['attachmentsDir'], TRUE, FALSE);
    }
  }

    /**
     * @param $body
     *
     * https://github.com/zbateson/mail-mime-parser
     */
  static function parseEmail($headers, $body) {
    //Civi::log()->debug(__FUNCTION__, ['$body' => $body]);

    $extDir = CRM_Core_Resources::singleton()->getPath(E::LONG_NAME);
    require_once "{$extDir}/vendor/autoload.php";

    //first we need to construct the full content of the email
    $content = '';
    foreach ($headers as $header => $value) {
      $content .= "{$header}: {$value}\n";
    }
    $content .= $body;

    $parser = new PhpMimeMailParser\Parser();
    $parser->setText($content);
    $headers = $parser->getHeaders();
    $text = $parser->getMessageBody('text');
    $html = $parser->getMessageBody('html');
    $htmlEmbedded = $parser->getMessageBody('htmlEmbedded');
    $attachments = $parser->getAttachments();

    //extract boundary value
    $boundary = $headers['content-type'][0];
    $boundary = str_replace('multipart/mixed; boundary=', '', $boundary);
    $boundary = str_replace('multipart/alternative; boundary=', '', $boundary);
    $boundary = str_replace('"', '', $boundary);

    //save attachments to files
    $config = CRM_Core_Config::singleton();
    $fileUploadDir = $config->customFileUploadDir;
    $dirHash = substr(md5(openssl_random_pseudo_bytes(20)),-10);
    $parser->saveAttachments($fileUploadDir.$dirHash.'/');

    $attachmentList = [];
    foreach ($attachments as $attachment) {
      $attachmentList[] = $fileUploadDir.$dirHash.'/'.$attachment->getFilename();

      //embedded attachments are not getting stripped from the html, so we do so here
      $html = substr($html, 0, strpos($html, '--'.$boundary));
      $text = substr($text, 0, strpos($text, '--'.$boundary));
    }

    /*Civi::log()->debug(__FUNCTION__, [
      //'$parser' => $parser,
      '$content' => $content,
      '$headers' => $headers,
      '$boundary' => $boundary,
      '$text' => $text,
      '$html' => $html,
      //'$htmlEmbedded' => $htmlEmbedded,
      //'$attachments' => $attachments,
      '$dirHash' => $dirHash,
      '$attachmentList' => $attachmentList,
      'attachmentsDir' => $fileUploadDir.$dirHash,
    ]);*/

    return [
      'text' => $text,
      'html' => $html,
      'htmlEmbedded' => $htmlEmbedded,
      'attachments' => $attachmentList,
      'attachmentsDir' => $fileUploadDir.$dirHash,
    ];
  }
}