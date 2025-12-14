<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Final Report - {{ $final->title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #c8102e;
            padding-bottom: 15px;
        }
        .header h1 {
            margin: 0;
            color: #c8102e;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 12px;
            color: #666;
        }
        .section {
            margin-bottom: 20px;
        }
        .section h2 {
            background-color: #f3f4f6;
            padding: 10px;
            border-left: 4px solid #c8102e;
            font-size: 14px;
            margin: 0 0 10px 0;
        }
        .section p {
            margin: 0 0 10px 0;
            line-height: 1.6;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 15px;
            font-size: 11px;
        }
        table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
        }
        table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .label {
            font-weight: bold;
            width: 30%;
            color: #555;
        }
        .footer {
            margin-top: 40px;
            border-top: 1px solid #ddd;
            padding-top: 15px;
            text-align: center;
            font-size: 10px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Final Report</h1>
        <p>E-PRONOC System</p>
        <p>Generated on {{ now()->format('d F Y H:i') }}</p>
    </div>

    <div class="section">
        <h2>Project Information</h2>
        <table>
            <tr>
                <td class="label">Project Title:</td>
                <td>{{ $final->title }}</td>
            </tr>
            <tr>
                <td class="label">Report Date:</td>
                <td>{{ \Carbon\Carbon::parse($final->date)->format('d F Y') }}</td>
            </tr>
            @if($final->focus_area)
            <tr>
                <td class="label">Focus Area:</td>
                <td>{{ $final->focus_area }}</td>
            </tr>
            @endif
            @if($final->focus)
            <tr>
                <td class="label">Focus:</td>
                <td>{{ $final->focus }}</td>
            </tr>
            @endif
            @if($final->statement_letter)
            <tr>
                <td class="label">Statement Letter:</td>
                <td>{{ $final->statement_letter }}</td>
            </tr>
            @endif
        </table>
    </div>

    @if($final->abstract)
    <div class="section">
        <h2>Abstract</h2>
        <p>{{ $final->abstract }}</p>
    </div>
    @endif

    @if($final->introduction)
    <div class="section">
        <h2>Introduction</h2>
        <p>{{ $final->introduction }}</p>
    </div>
    @endif

    @if($final->project_method)
    <div class="section">
        <h2>Project Method</h2>
        <p>{{ $final->project_method }}</p>
    </div>
    @endif

    @if($final->results)
    <div class="section">
        <h2>Research and Analysis Results</h2>
        <p>{{ $final->results }}</p>
    </div>
    @endif

    @if($final->bibliography)
    <div class="section">
        <h2>Bibliography</h2>
        <p>{{ $final->bibliography }}</p>
    </div>
    @endif

    <div class="footer">
        <p>This is an auto-generated document from E-PRONOC system.<br>
        Document ID: FR-{{ $final->id }}-{{ $final->project_id ?? 'N/A' }}<br>
        © 2025 All Rights Reserved</p>
    </div>
</body>
</html>