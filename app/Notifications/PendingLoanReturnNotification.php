<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use App\Models\EquipmentLoan;

class PendingLoanReturnNotification extends Notification
{
    use Queueable;

    protected $loan;
    protected $cadetName;
    protected $itemName;

    /**
     * Create a new notification instance.
     */
    public function __construct(EquipmentLoan $loan, string $cadetName, string $itemName)
    {
        $this->loan = $loan;
        $this->cadetName = $cadetName;
        $this->itemName = $itemName;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'Permintaan Pulangan Peralatan',
            'message' => $this->cadetName . ' telah memohon untuk memulangkan ' . $this->itemName . ' (Kuantiti: ' . $this->loan->quantity . ').',
            'type' => 'loan_return_request',
            'loan_id' => $this->loan->id,
            'cadet_name' => $this->cadetName,
            'item_name' => $this->itemName,
            'quantity' => $this->loan->quantity,
            'icon' => 'alert',
            'url' => route('instructor.inventory') . '#loans'
        ];
    }
}
