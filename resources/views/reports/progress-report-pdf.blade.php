<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Progress Report</title>
    <style>
        body { font-family: sans-serif; color: #333; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #ddd; padding-bottom: 20px; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #c8102e; }
        .header p { margin: 5px 0; color: #666; font-size: 14px; }
        
        .meta-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
        .meta-table td { padding: 8px 0; vertical-align: top; }
        .meta-label { width: 140px; font-weight: bold; color: #555; }
        .meta-value { font-weight: normal; }

        .section { margin-bottom: 25px; }
        .section-title { font-size: 16px; font-weight: bold; color: #c8102e; border-bottom: 1px solid #eee; padding-bottom: 5px; margin-bottom: 10px; text-transform: uppercase; }
        .content { font-size: 14px; text-align: justify; }
        
        .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 12px; font-weight: bold; background: #eee; }
        .badge-complete { background: #dcfce7; color: #166534; }
    </style>
</head>
<body>

    <div class="header">
        <h1>Progress Report</h1>
        <p>E-PRONOC System • Generated on {{ now()->format('d M Y') }}</p>
    </div>

    <table class="meta-table">
        <tr>
            <td class="meta-label">Project Title</td>
            <td class="meta-value">: {{ $report->proposal->title }}</td>
        </tr>
        <tr>
            <td class="meta-label">Focus Area</td>
            <td class="meta-value">: {{ $report->proposal->focus_area }}</td>
        </tr>
        <tr>
            <td class="meta-label">Specific Focus</td>
            <td class="meta-value">: {{ $report->proposal->output ?? '-' }}</td>
        </tr>
        <tr>
            <td class="meta-label">Report Date</td>
            <td class="meta-value">: {{ \Carbon\Carbon::parse($report->report_date)->format('d F Y') }}</td>
        </tr>
        <tr>
            <td class="meta-label">Completion</td>
            <td class="meta-value">: 
                @if($report->percentage_complete == 100)
                    <span class="badge badge-complete">100% (Complete)</span>
                @else
                    {{ $report->percentage_complete }}%
                @endif
            </td>
        </tr>
    </table>

    @if($report->activities)
    <div class="section">
        <div class="section-title">Activities Conducted</div>
        <div class="content">{!! $report->activities !!}</div>
    </div>
    @endif

    @if($report->results)
    <div class="section">
        <div class="section-title">Results Achieved</div>
        <div class="content">{!! $report->results !!}</div>
    </div>
    @endif

    @if($report->obstacles)
    <div class="section">
        <div class="section-title">Obstacles & Solutions</div>
        <div class="content">{!! $report->obstacles !!}</div>
    </div>
    @endif

    @if($report->next_steps)
    <div class="section">
        <div class="section-title">Next Steps</div>
        <div class="content">{!! $report->next_steps !!}</div>
    </div>
    @endif

    @if($report->notes)
    <div class="section">
        <div class="section-title">Additional Notes</div>
        <div class="content">{{ $report->notes }}</div>
    </div>
    @endif

</body>
</html>