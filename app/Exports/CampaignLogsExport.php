<?php

namespace App\Exports;

use App\Models\Message;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CampaignLogsExport implements FromView, WithTitle, ShouldAutoSize, WithStyles
{
    use Exportable;

    protected $campaignId;
    protected $status;

    public function __construct($campaignId, $status = null)
    {
        $this->campaignId = $campaignId;
        $this->status = $status;
    }

    public function title(): string
    {
        return 'Campaign Logs';
    }

    public function view(): View
    {
        $query = Message::query()
            ->where('campaign_id', $this->campaignId)
            ->with('contact')
            ->withPermission();

        if ($this->status) {
            if ($this->status === 'delivered') {
                $query->whereIn('status', ['read', 'delivered']);
            } else {
                $query->where('status', $this->status);
            }
        }

        $messages = $query->latest('id')->limit(10000)->get();

        return view('backend.exports.campaign-logs', compact('messages'));
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }
}
