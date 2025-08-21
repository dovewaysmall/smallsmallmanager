<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Payout Receipt - SmallSmall</title>
    <style>
        @media print {
            @page {
                margin: 0.5in;
                size: A4;
            }
            body {
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
            .no-print {
                display: none !important;
            }
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 20px;
            background: #f8f9fa;
            line-height: 1.6;
        }

        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .receipt-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }

        .logo {
            max-width: 200px;
            height: auto;
            margin-bottom: 15px;
            filter: brightness(0) invert(1);
        }

        .receipt-title {
            font-size: 28px;
            font-weight: bold;
            margin: 0;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }

        .receipt-subtitle {
            font-size: 14px;
            opacity: 0.9;
            margin: 5px 0 0 0;
        }

        .receipt-body {
            padding: 40px;
        }

        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        .info-block {
            flex: 1;
            min-width: 250px;
            margin-bottom: 20px;
        }

        .info-title {
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            color: #6c757d;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }

        .info-content {
            font-size: 16px;
            color: #212529;
            font-weight: 500;
        }

        .payout-details {
            border: 2px solid #e9ecef;
            border-radius: 8px;
            overflow: hidden;
            margin: 30px 0;
        }

        .payout-details-header {
            background: #f8f9fa;
            padding: 15px 20px;
            border-bottom: 1px solid #e9ecef;
            font-weight: bold;
            color: #495057;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            padding: 15px 20px;
            border-bottom: 1px solid #f1f3f4;
        }

        .detail-row:last-child {
            border-bottom: none;
        }

        .detail-label {
            font-weight: 600;
            color: #6c757d;
            flex: 1;
        }

        .detail-value {
            font-weight: 500;
            color: #212529;
            text-align: right;
            flex: 1;
        }

        .amount-highlight {
            font-size: 20px;
            color: #28a745;
            font-weight: bold;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-failed {
            background: #f8d7da;
            color: #721c24;
        }

        .status-processing {
            background: #d1ecf1;
            color: #0c5460;
        }

        .receipt-footer {
            background: #f8f9fa;
            padding: 25px;
            text-align: center;
            border-top: 1px solid #e9ecef;
        }

        .footer-text {
            color: #6c757d;
            font-size: 14px;
            margin: 0;
        }

        .company-info {
            margin-top: 15px;
            color: #495057;
            font-size: 12px;
        }

        .print-button {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #007bff;
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(0, 123, 255, 0.3);
            transition: all 0.3s ease;
            z-index: 1000;
        }

        .print-button:hover {
            background: #0056b3;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 123, 255, 0.4);
        }

        .back-button {
            position: fixed;
            bottom: 30px;
            left: 30px;
            background: #6c757d;
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 50px;
            font-size: 16px;
            font-weight: bold;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
            z-index: 1000;
        }

        .back-button:hover {
            background: #545b62;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.4);
            text-decoration: none;
            color: white;
        }

        @media (max-width: 768px) {
            .receipt-info {
                flex-direction: column;
            }
            
            .info-block {
                min-width: 100%;
            }
            
            .detail-row {
                flex-direction: column;
                gap: 5px;
            }
            
            .detail-value {
                text-align: left;
            }
            
            .print-button, .back-button {
                position: relative;
                bottom: auto;
                right: auto;
                left: auto;
                margin: 10px 5px;
                display: inline-block;
            }
        }

        .loading {
            text-align: center;
            padding: 50px;
            color: #6c757d;
        }

        .error {
            text-align: center;
            padding: 50px;
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="receipt-container">
        <div class="receipt-header">
            <img src="{{ asset('assets/images/logos/rentsmallsmall-logo-blue.png') }}" alt="SmallSmall Logo" class="logo" id="logo">
            <h1 class="receipt-title">Payout Receipt</h1>
            <p class="receipt-subtitle">Official Payment Receipt</p>
        </div>

        <div class="receipt-body" id="receiptContent">
            <div class="loading" id="loadingState">
                <h3>Loading receipt details...</h3>
                <p>Please wait while we retrieve your payout information.</p>
            </div>

            <div class="error" id="errorState" style="display: none;">
                <h3>Unable to Load Receipt</h3>
                <p id="errorMessage">There was an error loading the payout details.</p>
            </div>

            <div id="receiptData" style="display: none;">
                <div class="receipt-info">
                    <div class="info-block">
                        <div class="info-title">Receipt Number</div>
                        <div class="info-content" id="receiptNumber">-</div>
                    </div>
                    <div class="info-block">
                        <div class="info-title">Issue Date</div>
                        <div class="info-content" id="issueDate">-</div>
                    </div>
                </div>

                <div class="payout-details">
                    <div class="payout-details-header">
                        Payout Details
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Payout ID:</div>
                        <div class="detail-value" id="payoutId">-</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Recipient:</div>
                        <div class="detail-value" id="recipient">-</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Amount Paid:</div>
                        <div class="detail-value amount-highlight" id="amount">-</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Status:</div>
                        <div class="detail-value" id="status">-</div>
                    </div>
                    <div class="detail-row">
                        <div class="detail-label">Payment Date:</div>
                        <div class="detail-value" id="paymentDate">-</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="receipt-footer">
            <p class="footer-text">
                This is an official receipt generated by SmallSmall Property Management System.
            </p>
            <div class="company-info">
                <strong>SmallSmall Technologies Ltd.</strong><br>
                Property Management Solutions<br>
                Generated on <span id="generatedDate">-</span>
            </div>
        </div>
    </div>

    <button class="print-button no-print" onclick="window.print()">
        🖨️ Print Receipt
    </button>
    
    <a href="{{ url()->previous() }}" class="back-button no-print">
        ← Back
    </a>

    <script>
        let landlordMap = {};

        // Get payout ID from URL
        const urlParts = window.location.pathname.split('/');
        const payoutId = urlParts[urlParts.indexOf('payout') + 1]; // /payout/{id}/receipt
        
        console.log('URL parts:', urlParts);
        console.log('Payout ID extracted:', payoutId);

        function showState(stateName) {
            document.getElementById('loadingState').style.display = 'none';
            document.getElementById('errorState').style.display = 'none';
            document.getElementById('receiptData').style.display = 'none';
            
            if (stateName) {
                document.getElementById(stateName).style.display = 'block';
            }
        }

        function showError(message) {
            document.getElementById('errorMessage').textContent = message;
            showState('errorState');
        }

        async function loadLandlords() {
            try {
                const response = await fetch('{{ route("landlords.load") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });
                
                const data = await response.json();
                if (data.success && data.landlords) {
                    landlordMap = {};
                    data.landlords.forEach(landlord => {
                        const landlordId = landlord.userID || landlord.user_id || landlord.id;
                        const landlordName = `${landlord.firstName} ${landlord.lastName}` || 
                                           `${landlord.first_name} ${landlord.last_name}` || 
                                           landlord.name || 
                                           `Landlord ${landlordId}`;
                        landlordMap[landlordId] = landlordName;
                    });
                }
            } catch (error) {
                console.error('Error loading landlords:', error);
            }
        }

        async function loadReceiptData() {
            if (!payoutId || payoutId === 'undefined') {
                showError('Invalid payout ID: ' + payoutId);
                return;
            }
            
            showState('loadingState');
            
            try {
                // Check if CSRF token is available
                const csrfToken = document.querySelector('meta[name="csrf-token"]');
                if (!csrfToken) {
                    showError('CSRF token not found. Please refresh the page.');
                    return;
                }
                
                console.log('Loading landlords...');
                // First load landlords for name mapping
                await loadLandlords();
                
                console.log('Loading payout details for ID:', payoutId);
                // Then load payout details
                const response = await fetch('{{ route("payouts.load") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken.getAttribute('content')
                    }
                });
                
                console.log('Response status:', response.status);
                
                if (!response.ok) {
                    throw new Error(`HTTP ${response.status}: ${response.statusText}`);
                }
                
                const data = await response.json();
                console.log('Response data:', data);
                
                if (data.success && data.payouts) {
                    const payout = data.payouts.find(p => 
                        String(p.id) === String(payoutId) || 
                        String(p.payout_id) === String(payoutId)
                    );
                    
                    if (payout) {
                        console.log('Found payout:', payout);
                        populateReceipt(payout);
                        showState('receiptData');
                    } else {
                        showError(`Payout with ID ${payoutId} not found in ${data.payouts.length} payouts`);
                    }
                } else {
                    showError(data.error || 'Failed to load payout details');
                }
            } catch (error) {
                console.error('Error loading receipt data:', error);
                showError(`Network error: ${error.message}`);
            }
        }

        function populateReceipt(payout) {
            // Basic payout information
            const payoutIdValue = payout.id || payout.payout_id || 'N/A';
            const reference = payout.reference || payout.transaction_reference || payout.ref || 'N/A';
            
            // Get landlord name using landlord_id lookup
            const landlordId = payout.landlord_id;
            const recipient = landlordMap[landlordId] || payout.landlord_name || payout.recipient_name || payout.recipient || payout.user_name || landlordId || 'N/A';
            
            const amount = payout.amount || payout.payout_amount || '0.00';
            const status = payout.status || payout.payout_status || 'pending';
            const datePaid = payout.date_paid || payout.payout_date || payout.date || 'N/A';
            const createdAt = payout.created_at || 'N/A';
            
            // Format dates
            let formattedDatePaid = datePaid;
            let formattedCreatedAt = createdAt;
            
            if (datePaid !== 'N/A' && datePaid) {
                try {
                    formattedDatePaid = new Date(datePaid).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                } catch (e) {
                    formattedDatePaid = datePaid;
                }
            }
            
            if (createdAt !== 'N/A' && createdAt) {
                try {
                    formattedCreatedAt = new Date(createdAt).toLocaleDateString('en-US', {
                        year: 'numeric',
                        month: 'long',
                        day: 'numeric'
                    });
                } catch (e) {
                    formattedCreatedAt = createdAt;
                }
            }
            
            // Status badge class
            let statusClass = 'status-badge status-pending';
            switch (status.toLowerCase()) {
                case 'completed':
                case 'success':
                case 'paid':
                    statusClass = 'status-badge status-completed';
                    break;
                case 'pending':
                    statusClass = 'status-badge status-pending';
                    break;
                case 'failed':
                case 'declined':
                    statusClass = 'status-badge status-failed';
                    break;
                case 'processing':
                    statusClass = 'status-badge status-processing';
                    break;
            }
            
            // Populate receipt fields
            document.getElementById('receiptNumber').textContent = payoutIdValue;
            document.getElementById('issueDate').textContent = new Date().toLocaleDateString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
            document.getElementById('payoutId').textContent = payoutIdValue;
            document.getElementById('recipient').textContent = recipient;
            document.getElementById('amount').textContent = `₦${parseFloat(amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
            document.getElementById('status').innerHTML = `<span class="${statusClass}">${status}</span>`;
            document.getElementById('paymentDate').textContent = formattedDatePaid;
            document.getElementById('generatedDate').textContent = new Date().toLocaleString('en-US', {
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit'
            });
            
            // Update page title
            document.title = `Receipt - ${payoutIdValue} - SmallSmall`;
        }

        // Load receipt data when page is ready
        document.addEventListener('DOMContentLoaded', function() {
            loadReceiptData();
        });
    </script>
</body>
</html>