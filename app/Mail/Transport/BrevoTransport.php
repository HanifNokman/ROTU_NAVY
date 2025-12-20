<?php

namespace App\Mail\Transport;

use Brevo\Client\Api\TransactionalEmailsApi;
use Brevo\Client\Configuration;
use Brevo\Client\Model\SendSmtpEmail;
use Brevo\Client\Model\SendSmtpEmailSender;
use Brevo\Client\Model\SendSmtpEmailTo;
use Brevo\Client\Model\SendSmtpEmailReplyTo;
use Brevo\Client\Model\SendSmtpEmailAttachment;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Mailer\SentMessage;
use Symfony\Component\Mailer\Transport\AbstractTransport;
use Symfony\Component\Mime\Email;

class BrevoTransport extends AbstractTransport
{
    /**
     * The Brevo API key.
     */
    protected string $key;

    /**
     * The Brevo API instance.
     */
    protected TransactionalEmailsApi $brevo;

    /**
     * Create a new Brevo transport instance.
     */
    public function __construct(string $key)
    {
        $this->key = $key;

        // Configure Brevo API
        $config = Configuration::getDefaultConfiguration()->setApiKey('api-key', $this->key);
        $this->brevo = new TransactionalEmailsApi(
            new Client(),
            $config
        );

        parent::__construct();
    }

    /**
     * {@inheritDoc}
     */
    protected function doSend(SentMessage $message): void
    {
        $email = $message->getOriginalMessage();

        if (!$email instanceof Email) {
            throw new \InvalidArgumentException('Message must be an instance of Symfony\Component\Mime\Email');
        }

        $sendSmtpEmail = new SendSmtpEmail();

        // Set sender
        $from = $email->getFrom();
        if (!empty($from)) {
            $fromAddress = $from[0];
            $senderData = ['email' => $fromAddress->getAddress()];
            if ($fromAddress->getName()) {
                $senderData['name'] = $fromAddress->getName();
            }
            $sender = new SendSmtpEmailSender($senderData);
            $sendSmtpEmail->setSender($sender);
        }

        // Set recipients
        $to = [];
        foreach ($email->getTo() as $address) {
            $recipient = ['email' => $address->getAddress()];
            if ($address->getName()) {
                $recipient['name'] = $address->getName();
            }
            $to[] = new SendSmtpEmailTo($recipient);
        }
        $sendSmtpEmail->setTo($to);

        // Set CC recipients
        if ($email->getCc()) {
            $cc = [];
            foreach ($email->getCc() as $address) {
                $recipient = ['email' => $address->getAddress()];
                if ($address->getName()) {
                    $recipient['name'] = $address->getName();
                }
                $cc[] = new SendSmtpEmailTo($recipient);
            }
            $sendSmtpEmail->setCc($cc);
        }

        // Set BCC recipients
        if ($email->getBcc()) {
            $bcc = [];
            foreach ($email->getBcc() as $address) {
                $recipient = ['email' => $address->getAddress()];
                if ($address->getName()) {
                    $recipient['name'] = $address->getName();
                }
                $bcc[] = new SendSmtpEmailTo($recipient);
            }
            $sendSmtpEmail->setBcc($bcc);
        }

        // Set reply-to
        if ($email->getReplyTo()) {
            $replyToAddress = $email->getReplyTo()[0];
            $replyToData = ['email' => $replyToAddress->getAddress()];
            if ($replyToAddress->getName()) {
                $replyToData['name'] = $replyToAddress->getName();
            }
            $replyTo = new SendSmtpEmailReplyTo($replyToData);
            $sendSmtpEmail->setReplyTo($replyTo);
        }

        // Set subject
        $sendSmtpEmail->setSubject($email->getSubject());

        // Set content
        $htmlBody = $email->getHtmlBody();
        $textBody = $email->getTextBody();

        if ($htmlBody) {
            $sendSmtpEmail->setHtmlContent($htmlBody);
        }

        if ($textBody) {
            $sendSmtpEmail->setTextContent($textBody);
        }

        // Handle attachments
        if ($email->getAttachments()) {
            $attachments = [];
            foreach ($email->getAttachments() as $attachment) {
                $filename = $attachment->getPreparedHeaders()->getHeaderParameter('Content-Disposition', 'filename') ?? 'attachment';

                $brevoAttachment = new SendSmtpEmailAttachment([
                    'content' => base64_encode($attachment->getBody()),
                    'name' => $filename,
                ]);

                $attachments[] = $brevoAttachment;
            }
            $sendSmtpEmail->setAttachment($attachments);
        }

        try {
            // Send email via Brevo API
            $result = $this->brevo->sendTransacEmail($sendSmtpEmail);

            Log::info('Email sent via Brevo', [
                'message_id' => $result->getMessageId(),
            ]);
        } catch (\Exception $e) {
            Log::error('Brevo email send failed', [
                'error' => $e->getMessage(),
                'code' => $e->getCode(),
            ]);

            throw $e;
        }
    }

    /**
     * Get the string representation of the transport.
     */
    public function __toString(): string
    {
        return 'brevo';
    }
}
