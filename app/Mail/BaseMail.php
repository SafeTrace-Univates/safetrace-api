<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\HtmlString;

/**
 * Classe pai para Mailables reutilizáveis.
 */
class BaseMail extends Mailable
{
    use Queueable;
    use SerializesModels;

    protected string $subjectText;
    protected string $content;

    protected $headerPath;
    protected $footerPath;

    protected array  $fromData;
    protected ?array $replyToData;
    protected array  $toData;
    protected array  $ccData;
    protected array  $bccData;

    public function __construct(
        string $subject,
        string $content,
        array $attachments = [],
        string $view = 'emails.base_mail'
    ) {
        $this->subjectText    = $subject;
        $this->content        = $content;
        $this->rawAttachments = $attachments;
        $this->headerPath     = resource_path('assets/header_email.png');
        $this->footerPath     = resource_path('assets/footer_email.png');
        $this->view           = $view;
    }

    public function build(): self
    {
        $this->subject($this->subjectText);

        $this->rawAttachments = array_map(fn ($a) => [
            'data'    => base64_decode($a['data']),
            'name'    => ($a['name'] ?? 'attachment'),
            'options' => ['mime' => $a['mime'] ?? 'application/octet-stream'],
        ], $this->rawAttachments);

        return $this->view($this->view)
            ->with([
                'content'      => new HtmlString($this->content),
                'headerBase64' => base64_encode(file_get_contents($this->headerPath)),
                'footerBase64' => base64_encode(file_get_contents($this->footerPath)),
            ]);
    }
}
