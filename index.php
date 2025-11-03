<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Shipping Label Generator</title>
  <!-- Bootstrap 5.3.8 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" />
  <style>
    /* Tabel list labels di layar */
    table.print-table {
      width: 100%;
      border-collapse: collapse;
      box-shadow: 0 0 5px rgba(0,0,0,.15);
      font-family: Arial, sans-serif;
      font-size: 14px;
    }
    table.print-table thead tr {
      background-color: #24427a;
      color: white;
      font-weight: 600;
      font-size: 13px;
    }
    table.print-table th,
    table.print-table td {
      border: 1px solid #999;
      padding: 6px 8px;
      vertical-align: middle;
    }
    table.print-table tbody tr:nth-child(odd) {
      background-color: #6a789f8c;
      color: white;
    }
    table.print-table tbody tr:hover:not(.highlight) {
      background-color: #92d9c1;
      color: black;
    }
    /* Tabel print labels - tiap label akan ada tabel kecil */
    .label-table {
      width: 100%;
      border-collapse: collapse;
      font-family: Arial, sans-serif;
      font-size: 12px;
    }
    .label-table th, .label-table td {
      border: 1px solid #24427a;
      padding: 4px 6px;
      text-align: left;
    }
    .label-table thead tr {
      background-color: #24427a;
      color: white;
    }
    .label-table tbody tr:nth-child(odd) {
      background-color: #6a789f8c;
      color: white;
    }
    /* Layout print: 3 kolom x 2 baris, grid */
    @media print {
      body {
        margin: 10mm;
      }
      .page {
        width: 210mm;
        height: 297mm;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        grid-template-rows: repeat(2, 1fr);
        gap: 10px;
        page-break-after: always;
      }
      .label-card {
        border: none;
        padding: 0;
        box-sizing: border-box;
        font-size: 12px;
      }
      /* Hide unneeded elements on print */
      #labelForm,
      #printAllBtn,
      #labelListTable {
        display: none !important;
      }
    }
  </style>
</head>
<body>
  <div class="container mt-5">
    <h1 class="text-center mb-4">Shipping Label Generator</h1>
    <form id="labelForm" class="row g-3">
      <div class="col-md-6">
        <label for="noSerUl" class="form-label">No Ser UL</label>
        <input type="text" class="form-control" id="noSerUl" placeholder="Enter No Ser UL" required />
      </div>
      <div class="col-md-6">
        <label for="poNo" class="form-label">P/O No</label>
        <input type="text" class="form-control" id="poNo" placeholder="Enter P/O No" required />
      </div>

      <div class="col-md-6">
        <label for="deliveryDate" class="form-label">Tanggal (Delivery Date)</label>
        <input type="date" class="form-control" id="deliveryDate" required />
      </div>

      <div class="col-md-6">
        <label for="partNumber" class="form-label">Part No</label>
        <input type="text" class="form-control" id="partNumber" list="partNumberList" placeholder="Type to search" required />
        <datalist id="partNumberList">
          <option value="32101-KPH-8801-C1" />
          <option value="PN002" />
          <option value="PN003" />
          <option value="PN004" />
        </datalist>
      </div>

      <div class="col-md-6">
        <label for="partName" class="form-label">Part Name (Auto Filled)</label>
        <input type="text" class="form-control" id="partName" readonly />
      </div>

      <div class="col-md-3">
        <label for="qty" class="form-label">Qty</label>
        <input type="number" class="form-control" id="qty" min="1" required />
      </div>

      <div class="col-md-3">
        <label for="packQty" class="form-label">Pack Qty (pcs per box)</label>
        <input type="number" class="form-control" id="packQty" min="1" required />
      </div>

      <div class="col-12">
        <label for="remark" class="form-label">Remark (Optional)</label>
        <textarea class="form-control" id="remark" rows="2" placeholder="Optional remark"></textarea>
      </div>

      <div class="col-12">
        <button type="submit" class="btn btn-primary" id="generateBtn">Generate Labels</button>
      </div>
    </form>

    <!-- Table list labels -->
    <div id="printList" class="mt-4" style="display: none;">
      <h3>Labels to Print</h3>
      <table class="table print-table" id="labelListTable">
        <thead>
          <tr>
            <th>#</th>
            <th>No Ser UL</th>
            <th>P/O No</th>
            <th>Tanggal</th>
            <th>Part No</th>
            <th>Part Name</th>
            <th>Qty</th>
            <th>Remark</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody id="labelTableBody"></tbody>
      </table>
      <button id="printAllBtn" class="btn btn-success">Print All</button>
    </div>
  </div>

  <script>
    // Data simulasi part no dan name
    const partData = {
      "32101-KPH-8801-C1": "SUB HARNESS SPEEDOMETER ANFD",
      "PN002": "Part Name 2",
      "PN003": "Part Name 3",
      "PN004": "Part Name 4"
    };

    let generatedLabels = [];
    let labelCounter = 1;

    // Auto-fill Part Name
    document.getElementById("partNumber").addEventListener("input", function () {
      const val = this.value;
      document.getElementById("partName").value = partData[val] || "";
    });

    // Membuat label array sesuai qty dan packQty
    function createLabels(data) {
      const labels = [];
      const boxes = Math.ceil(data.qty / data.packQty);
      for (let i = 0; i < boxes; i++) {
        const qtyThisBox = i === boxes - 1 ? data.qty - data.packQty * i : data.packQty;
        labels.push({
          id: labelCounter++,
          noSerUl: data.noSerUl,
          poNo: data.poNo,
          tanggal: data.deliveryDate,
          partNo: data.partNumber,
          partName: data.partName,
          qty: qtyThisBox,
          remark: data.remark || ''
        });
      }
      return labels;
    }

    // Submit form
    document.getElementById("labelForm").addEventListener("submit", function (e) {
      e.preventDefault();

      const noSerUl = this.noSerUl.value.trim();
      const poNo = this.poNo.value.trim();
      const deliveryDate = this.deliveryDate.value.trim();
      const partNumber = this.partNumber.value.trim();
      const partName = this.partName.value.trim();
      const qty = parseInt(this.qty.value);
      const packQty = parseInt(this.packQty.value);
      const remark = this.remark.value.trim();

      if (!noSerUl || !poNo || !deliveryDate || !partNumber || !partName || qty < 1 || packQty < 1) {
        alert("Please fill all required fields with valid values.");
        return;
      }

      const newLabels = createLabels({
        noSerUl,
        poNo,
        deliveryDate,
        partNumber,
        partName,
        qty,
        packQty,
        remark
      });

      generatedLabels.push(...newLabels);

      renderTable();
      document.getElementById("printList").style.display = "block";
      this.reset();
      this.partName.value = "";
    });

    // Render tabel list labels
    function renderTable() {
      const tbody = document.getElementById("labelTableBody");
      tbody.innerHTML = "";
      generatedLabels.forEach((label, idx) => {
        const tr = document.createElement("tr");
        if (idx % 2 === 1) tr.style.backgroundColor = "rgba(106, 120, 159, 0.55)";
        else tr.style.backgroundColor = "transparent";
        tr.style.color = idx % 2 === 1 ? "white" : "black";
        tr.dataset.id = label.id;
        tr.innerHTML = `
          <td>${idx + 1}</td>
          <td>${label.noSerUl}</td>
          <td>${label.poNo}</td>
          <td>${label.tanggal}</td>
          <td>${label.partNo}</td>
          <td>${label.partName}</td>
          <td>${label.qty}</td>
          <td>${label.remark}</td>
          <td><button class="btn btn-danger btn-sm" onclick="removeLabel(${label.id})">Remove</button></td>
        `;
        tbody.appendChild(tr);
      });

      if (generatedLabels.length === 0) {
        document.getElementById("printList").style.display = "none";
      }
    }

    // Hapus label dari list
    function removeLabel(id) {
      generatedLabels = generatedLabels.filter(l => l.id !== id);
      renderTable();
    }

    // Print semua label
    document.getElementById("printAllBtn").addEventListener("click", function () {
      if (generatedLabels.length === 0) {
        alert("No labels to print.");
        return;
      }
      const printWindow = window.open("", "_blank");
      let html = `
        <html><head><title>Print Labels</title>
        <style>
          @page { size: A4; margin: 10mm; }
          body {
            margin: 0; padding: 0; font-family: Arial, sans-serif;
          }
          .page {
            width: 210mm;
            height: 297mm;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            grid-template-rows: repeat(2, 1fr);
            gap: 10px;
            page-break-after: always;
          }
          .label-card {
            border: 1px solid #24427a;
            padding: 4px;
            box-sizing: border-box;
            font-size: 12px;
            background: white;
          }
          table.label-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
          }
          table.label-table th, table.label-table td {
            border: 1px solid #24427a;
            padding: 3px 5px;
            text-align: left;
          }
          table.label-table thead tr {
            background-color: #24427a;
            color: white;
          }
          table.label-table tbody tr:nth-child(odd) {
            background-color: rgba(106, 120, 159, 0.55);
            color: white;
          }
        
        .desktop {
        position: relative;
        width: 1280px;
        height: 1080px;
        background-color: #ffffff;
        }

        .desktop .rectangle {
        top: 58px;
        left: 29px;
        width: 594px;
        height: 387px;
        border-color: #010101;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        }

        .desktop .div {
        top: 57px;
        left: 26px;
        width: 597px;
        height: 388px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        }

        .desktop .rectangle-2 {
        top: 57px;
        left: 264px;
        width: 359px;
        height: 389px;
        border-color: #040404;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        }

        .desktop .rectangle-3 {
        top: 57px;
        left: 26px;
        width: 239px;
        height: 61px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        }

        .desktop .rectangle-4 {
        top: 172px;
        left: 26px;
        width: 239px;
        height: 43px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        }

        .desktop .rectangle-5 {
        top: 211px;
        left: 26px;
        width: 239px;
        height: 40px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        }

        .desktop .rectangle-6 {
        top: 211px;
        left: 264px;
        width: 359px;
        height: 40px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        }

        .desktop .rectangle-7 {
        top: 250px;
        left: 264px;
        width: 359px;
        height: 40px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        }

        .desktop .rectangle-8 {
        top: 289px;
        left: 264px;
        width: 359px;
        height: 40px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        }

        .desktop .rectangle-9 {
        top: 328px;
        left: 264px;
        width: 359px;
        height: 40px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        }

        .desktop .rectangle-10 {
        top: 367px;
        left: 264px;
        width: 359px;
        height: 40px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        }

        .desktop .rectangle-11 {
        top: 406px;
        left: 264px;
        width: 359px;
        height: 40px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        }

        .desktop .rectangle-12 {
        top: 250px;
        left: 26px;
        width: 237px;
        height: 40px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        }

        .desktop .rectangle-13 {
        top: 289px;
        left: 26px;
        width: 237px;
        height: 40px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        }

        .desktop .rectangle-14 {
        top: 328px;
        left: 26px;
        width: 237px;
        height: 40px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        }

        .desktop .rectangle-15 {
        top: 367px;
        left: 26px;
        width: 237px;
        height: 40px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        }

        .desktop .rectangle-16 {
        top: 406px;
        left: 26px;
        width: 239px;
        height: 40px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        }

        .desktop .rectangle-17 {
        top: 97px;
        left: 26px;
        width: 239px;
        height: 76px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        }

        .desktop .rectangle-18 {
        top: 57px;
        left: 264px;
        width: 359px;
        height: 153px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        }

        .desktop .text-wrapper {
        position: absolute;
        top: 58px;
        left: 106px;
        font-family: "Cabin-Bold", Helvetica;
        font-weight: 700;
        color: #000000;
        font-size: 32px;
        letter-spacing: 0;
        line-height: normal;
        }

        .desktop .text-wrapper-2 {
        position: absolute;
        top: 180px;
        left: 39px;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        letter-spacing: 0;
        line-height: normal;
        white-space: nowrap;
        }

        .desktop .images {
        position: absolute;
        top: 106px;
        left: 99px;
        width: 94px;
        height: 58px;
        aspect-ratio: 1.62;
        object-fit: cover;
        }

        .desktop .text-wrapper-3 {
        position: absolute;
        top: 220px;
        left: 39px;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        letter-spacing: 0;
        line-height: normal;
        white-space: nowrap;
        }

        .desktop .text-wrapper-4 {
        top: 258px;
        position: absolute;
        left: 39px;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        letter-spacing: 0;
        line-height: normal;
        white-space: nowrap;
        }

        .desktop .text-wrapper-5 {
        top: 297px;
        position: absolute;
        left: 39px;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        letter-spacing: 0;
        line-height: normal;
        white-space: nowrap;
        }

        .desktop .text-wrapper-6 {
        position: absolute;
        top: 335px;
        left: 39px;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        letter-spacing: 0;
        line-height: normal;
        white-space: nowrap;
        }

        .desktop .text-wrapper-7 {
        position: absolute;
        top: 375px;
        left: 39px;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        letter-spacing: 0;
        line-height: normal;
        white-space: nowrap;
        }

        .desktop .text-wrapper-8 {
        position: absolute;
        top: 414px;
        left: 39px;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        letter-spacing: 0;
        line-height: normal;
        white-space: nowrap;
        }

        .desktop .rectangle-19 {
        top: 445px;
        left: 26px;
        width: 239px;
        height: 40px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        }

        .desktop .rectangle-20 {
        top: 445px;
        left: 264px;
        width: 359px;
        height: 40px;
        border-color: #000000;
        position: absolute;
        background-color: #ffffff;
        border: 1px solid;
        }

        .desktop .text-wrapper-9 {
        position: absolute;
        top: 452px;
        left: 39px;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 20px;
        letter-spacing: 0;
        line-height: normal;
        white-space: nowrap;
        }

        .desktop .PT-MURAMOTO {
        position: absolute;
        top: 116px;
        left: 281px;
        font-family: "Cabin-Regular", Helvetica;
        font-weight: 400;
        color: #000000;
        font-size: 22px;
        text-align: center;
        letter-spacing: 0;
        line-height: normal;
        }

        </style>
        </head><body>`;

      for (let i = 0; i < generatedLabels.length; i += 6) {
        html += `<div class="page">`;
        const pageLabels = generatedLabels.slice(i, i + 6);
        pageLabels.forEach(label => {
          html += `
                <div class="desktop">
      <div class="rectangle"></div>
      <div class="div"></div>
      <div class="rectangle-2"></div>
      <div class="rectangle-3"></div>
      <div class="rectangle-4"></div>
      <div class="rectangle-5"></div>
      <div class="rectangle-6">${label.tanggal}</div>
      <div class="rectangle-7">${label.partNo}</div>
      <div class="rectangle-8">${label.partName}</div>
      <div class="rectangle-9">${label.poNo}</div>
      <div class="rectangle-10">${label.qty}</div>
      <div class="rectangle-11">${label.remark}</div>
      <div class="rectangle-12"></div>
      <div class="rectangle-13"></div>
      <div class="rectangle-14"></div>
      <div class="rectangle-15"></div>
      <div class="rectangle-16"></div>
      <div class="rectangle-17"></div>
      <div class="rectangle-18"></div>
      <div class="text-wrapper">RoHS</div>
      <div class="text-wrapper-2">No Ser UL</div>
      <img class="images" src="img/images-1-1.png"/>
      <div class="text-wrapper-3">Delivery Date</div>
      <div class="text-wrapper-3">Delivery Date</div>
      <div class="text-wrapper-4">Part No.</div>
      <div class="text-wrapper-5">Part Name</div>
      <div class="text-wrapper-6">P/O No</div>
      <div class="text-wrapper-7">Quantity</div>
      <div class="text-wrapper-7">Quantity</div>
      <div class="text-wrapper-8">Remark</div>
      <div class="rectangle-11"></div>
      <div class="text-wrapper-8">Remark</div>
      <div class="rectangle-19"></div>
      <div class="rectangle-20"></div>
      <div class="text-wrapper-9">Supplier</div>
      <div class="PT-MURAMOTO">PT. MURAMOTO ELECTRONIKA<br />INDONESIA</div>
    </div>
</body>
</html>

          
          
          
            <div class="label-card">
              <table class="label-table">
                <thead><tr>
                  <th>No Ser UL</th>
                  <th>P/O No</th>
                  <th>Tanggal</th>
                  <th>Part No</th>
                  <th>Part Name</th>
                  <th>Qty</th>
                </tr></thead>
                <tbody>
                  <tr>
                    <td>${label.noSerUl}</td>
                    <td>${label.poNo}</td>
                    <td>${label.tanggal}</td>
                    <td>${label.partNo}</td>
                    <td>${label.partName}</td>
                    <td>${label.qty}</td>
                  </tr>
                </tbody>
              </table>
            </div>`;
        });
        // Tambahkan kotak kosong untuk halaman grid lengkap
        const emptyCells = 6 - pageLabels.length;
        for(let e=0;e<emptyCells;e++){
          html += `<div class="label-card"></div>`;
        }
        html += `</div>`;
      }

      html += "</body></html>";

      printWindow.document.write(html);
      printWindow.document.close();
      printWindow.focus();
      printWindow.print();
    });

  </script>
</body>
</html>