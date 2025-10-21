<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Barangay Complaints Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            color: #1e40af;
        }
        .header p {
            margin: 5px 0;
            color: #666;
        }
        .report-date {
            text-align: center;
            color: #666;
            margin-bottom: 20px;
            font-size: 12px;
        }
        .stats {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
        }
        .stat-box {
            flex: 1;
            text-align: center;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin: 0 10px;
            background-color: #f9fafb;
        }
        .stat-box h3 {
            margin: 0 0 10px 0;
            font-size: 14px;
            color: #666;
        }
        .stat-box .number {
            font-size: 28px;
            font-weight: bold;
            color: #2563eb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table thead {
            background-color: #f3f4f6;
            border-bottom: 2px solid #2563eb;
        }
        table th {
            padding: 12px;
            text-align: left;
            font-weight: bold;
            color: #1e40af;
            border: 1px solid #ddd;
        }
        table td {
            padding: 10px 12px;
            border: 1px solid #ddd;
        }
        table tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            margin-top: 30px;
            margin-bottom: 15px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 10px;
        }
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        .status-validated {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        .status-in_progress {
            background-color: #e9d5ff;
            color: #6b21a8;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        .status-resolved {
            background-color: #dcfce7;
            color: #15803d;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        .status-rejected {
            background-color: #fee2e2;
            color: #991b1b;
            padding: 2px 8px;
            border-radius: 4px;
            font-size: 12px;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #999;
            border-top: 1px solid #ddd;
            padding-top: 20px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <h1>BARANGAY COMPLAINTS REPORT</h1>
        <p>Complaint Analysis, Intervention, and Recommendation System</p>
    </div>

    <!-- Report Date Range -->
    <div class="report-date">
        <strong>Report Period:</strong> {{ \Carbon\Carbon::parse($startDate)->format('F d, Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('F d, Y') }}
    </div>

    <!-- Statistics -->
    <div class="stats">
        <div class="stat-box">
            <h3>Total Complaints</h3>
            <div class="number">{{ $stats['total'] }}</div>
        </div>
        <div class="stat-box">
            <h3>Resolved</h3>
            <div class="number">{{ $stats['resolved'] }}</div>
        </div>
        <div class="stat-box">
            <h3>Pending</h3>
            <div class="number">{{ $stats['pending'] }}</div>
        </div>
        <div class="stat-box">
            <h3>Rejected</h3>
            <div class="number">{{ $stats['rejected'] }}</div>
        </div>
    </div>

    <!-- Complaints Table -->
    <div class="section-title">Detailed Complaints List</div>

    @if($complaints->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Subject</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Filed Date</th>
                    <th>Citizen</th>
                </tr>
            </thead>
            <tbody>
                @foreach($complaints as $complaint)
                    <tr>
                        <td>#{{ str_pad($complaint->id, 4, '0', STR_PAD_LEFT) }}</td>
                        <td>{{ Str::limit($complaint->subject, 40) }}</td>
                        <td>{{ $complaint->category->name ?? 'Unknown' }}</td>
                        <td>
                            <span class="status-{{ $complaint->status }}">
                                {{ str_replace('_', ' ', ucfirst($complaint->status)) }}
                            </span>
                        </td>
                        <td>{{ $complaint->created_at->format('M d, Y') }}</td>
                        <td>{{ $complaint->user->full_name }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p style="text-align: center; color: #999; padding: 20px;">No complaints found for the selected period.</p>
    @endif

    <!-- Summary Section -->
    <div class="section-title">Summary</div>

    <table>
        <thead>
            <tr>
                <th>Metric</th>
                <th>Value</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>Total Complaints Filed</strong></td>
                <td>{{ $stats['total'] }}</td>
                <td>100%</td>
            </tr>
            <tr>
                <td><strong>Resolved Complaints</strong></td>
                <td>{{ $stats['resolved'] }}</td>
                <td>{{ $stats['total'] > 0 ? round(($stats['resolved'] / $stats['total']) * 100, 1) : 0 }}%</td>
            </tr>
            <tr>
                <td><strong>Pending Complaints</strong></td>
                <td>{{ $stats['pending'] }}</td>
                <td>{{ $stats['total'] > 0 ? round(($stats['pending'] / $stats['total']) * 100, 1) : 0 }}%</td>
            </tr>
            <tr>
                <td><strong>Rejected Complaints</strong></td>
                <td>{{ $stats['rejected'] }}</td>
                <td>{{ $stats['total'] > 0 ? round(($stats['rejected'] / $stats['total']) * 100, 1) : 0 }}%</td>
            </tr>
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <p>Generated on {{ now()->format('F d, Y \a\t g:i A') }}</p>
        <p>This is an official report from the Barangay Complaint System</p>
    </div>
</body>
</html>
