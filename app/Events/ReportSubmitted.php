<?php

namespace App\Events;

use App\Models\AgencyReportAction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportSubmitted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $agencyAction;


    public function __construct(AgencyReportAction $agencyAction)
    {
        $this->agencyAction = $agencyAction;
    }   

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            'id' => $this->agencyAction->id,
            'submitted_report_id' => $this->agencyAction->submitted_report_id,
            'shortestpath_trigger_num' => $this->agencyAction->shortestpath_trigger_num,
            'nearest_agency_name' => $this->agencyAction->nearest_agency_name,
            'report_action' => $this->agencyAction->report_action
        ];
    }
}
