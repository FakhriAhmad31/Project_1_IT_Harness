<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Label</title>
    <style>
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-template-rows: repeat(4, 1fr);
            height: 100vh;
            gap: 10px;
            padding: 10px;
        }

        .label {
            border: 1px solid #000;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header img {
            width: 100px;
        }

        .info {
            margin-top: 10px;
        }

        .info div {
            margin-bottom: 8px;
        }

        .info div span {
            font-weight: bold;
        }

        .footer {
            margin-top: auto;
            display: flex;
            justify-content: space-between;
            font-size: 12px;
        }

        .footer div {
            flex: 1;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="label">
        <div class="header">
            <img src="https://via.placeholder.com/100x50?text=DAIKIN" alt="DAIKIN Logo">
            <span>Status</span>
        </div>
        <div class="info">
            <div><span>Part No:</span> 3P761958-1</div>
            <div><span>Part Name:</span> WIRE HARNESS ASSY (COMPRESSOR)</div>
            <div><span>P / O No:</span> -</div>
            <div><span>Delivery Date:</span> -</div>
            <div><span>Qty Delivery:</span> 600 Pcs</div>
            <div><span>Qty / Bucket:</span> 200 Pcs</div>
        </div>
        <div class="footer">
            <div>Bucket No: #REF!</div>
            <div>Supplier: WIRE HARNESS DIV.</div>
        </div>
    </div>

    <div class="label">
        <div class="header">
            <img src="https://via.placeholder.com/100x50?text=DAIKIN" alt="DAIKIN Logo">
            <span>Status</span>
        </div>
        <div class="info">
            <div><span>Part No:</span> 3P761958-1</div>
            <div><span>Part Name:</span> WIRE HARNESS ASSY (COMPRESSOR)</div>
            <div><span>P / O No:</span> -</div>
            <div><span>Delivery Date:</span> -</div>
            <div><span>Qty Delivery:</span> 600 Pcs</div>
            <div><span>Qty / Bucket:</span> 200 Pcs</div>
        </div>
        <div class="footer">
            <div>Bucket No: #REF!</div>
            <div>Supplier: WIRE HARNESS DIV.</div>
        </div>
    </div>

    <!-- Repeat the label for other 4 fields -->

    <div class="label">
        <div class="header">
            <img src="https://via.placeholder.com/100x50?text=DAIKIN" alt="DAIKIN Logo">
            <span>Status</span>
        </div>
        <div class="info">
            <div><span>Part No:</span> 3P761958-1</div>
            <div><span>Part Name:</span> WIRE HARNESS ASSY (COMPRESSOR)</div>
            <div><span>P / O No:</span> -</div>
            <div><span>Delivery Date:</span> -</div>
            <div><span>Qty Delivery:</span> 600 Pcs</div>
            <div><span>Qty / Bucket:</span> 200 Pcs</div>
        </div>
        <div class="footer">
            <div>Bucket No: #REF!</div>
            <div>Supplier: WIRE HARNESS DIV.</div>
        </div>
    </div>

    <div class="label">
        <div class="header">
            <img src="https://via.placeholder.com/100x50?text=DAIKIN" alt="DAIKIN Logo">
            <span>Status</span>
        </div>
        <div class="info">
            <div><span>Part No:</span> 3P761958-1</div>
            <div><span>Part Name:</span> WIRE HARNESS ASSY (COMPRESSOR)</div>
            <div><span>P / O No:</span> -</div>
            <div><span>Delivery Date:</span> -</div>
            <div><span>Qty Delivery:</span> 600 Pcs</div>
            <div><span>Qty / Bucket:</span> 200 Pcs</div>
        </div>
        <div class="footer">
            <div>Bucket No: #REF!</div>
            <div>Supplier: WIRE HARNESS DIV.</div>
        </div>
    </div>

    <div class="label">
        <div class="header">
            <img src="https://via.placeholder.com/100x50?text=DAIKIN" alt="DAIKIN Logo">
            <span>Status</span>
        </div>
        <div class="info">
            <div><span>Part No:</span> 3P761958-1</div>
            <div><span>Part Name:</span> WIRE HARNESS ASSY (COMPRESSOR)</div>
            <div><span>P / O No:</span> -</div>
            <div><span>Delivery Date:</span> -</div>
            <div><span>Qty Delivery:</span> 600 Pcs</div>
            <div><span>Qty / Bucket:</span> 200 Pcs</div>
        </div>
        <div class="footer">
            <div>Bucket No: #REF!</div>
            <div>Supplier: WIRE HARNESS DIV.</div>
        </div>
    </div>

    <div class="label">
        <div class="header">
            <img src="https://via.placeholder.com/100x50?text=DAIKIN" alt="DAIKIN Logo">
            <span>Status</span>
        </div>
        <div class="info">
            <div><span>Part No:</span> 3P761958-1</div>
            <div><span>Part Name:</span> WIRE HARNESS ASSY (COMPRESSOR)</div>
            <div><span>P / O No:</span> -</div>
            <div><span>Delivery Date:</span> -</div>
            <div><span>Qty Delivery:</span> 600 Pcs</div>
            <div><span>Qty / Bucket:</span> 200 Pcs</div>
        </div>
        <div class="footer">
            <div>Bucket No: #REF!</div>
            <div>Supplier: WIRE HARNESS DIV.</div>
        </div>
    </div>

    <div class="label">
        <div class="header">
            <img src="https://via.placeholder.com/100x50?text=DAIKIN" alt="DAIKIN Logo">
            <span>Status</span>
        </div>
        <div class="info">
            <div><span>Part No:</span> 3P761958-1</div>
            <div><span>Part Name:</span> WIRE HARNESS ASSY (COMPRESSOR)</div>
            <div><span>P / O No:</span> -</div>
            <div><span>Delivery Date:</span> -</div>
            <div><span>Qty Delivery:</span> 600 Pcs</div>
            <div><span>Qty / Bucket:</span> 200 Pcs</div>
        </div>
        <div class="footer">
            <div>Bucket No: #REF!</div>
            <div>Supplier: WIRE HARNESS DIV.</div>
        </div>
    </div>
</div>

</body>
</html>
