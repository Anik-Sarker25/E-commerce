<style>
    /* genarals */
    #printable-area {
        position: relative;
        width: 210mm;
        min-height: 297mm;
        background: transparent;
        margin: auto;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); /* Optional shadow */
    }
    #printable-area article *{
        font-size: 12px;
    }
    #printable-area h1 {
        font-size: 16px;
    }
    #printable-area p {
        margin-bottom: 0;
    }
    #printable-area * {
        font-family:  'Open Sans', sans-serif;
    }
    #printable-area th, #printable-area td {
        /* border: 1px solid #BBB; */
        vertical-align: middle;
        border-radius: 4px;
        padding: 6px;
    }
    #printable-area table {
        border-collapse: separate;
        border-spacing: 2px;
    }

    /* header part  */
    #printable-area .invoice-header {
        width: 100%;
        padding: 5mm 12mm;
        border-radius: 8px 8px 0 0;
        overflow: hidden;
    }
    #printable-area .header-items {
        z-index: 1000;
    }
    #printable-area .invoice-title {
        font-size: 24px;
        font-weight: bold;
        text-transform: uppercase;
    }
    #printable-area .company-logo img {
        max-height: 50px;
    }
    .urTable td::before,
    .brTable td::before {
        content: ': ';
        color: #888;
        font-size: 12px;
        margin-left: 5px;
    }


    /* main-content  */
    #printable-area article {
        padding: 8mm 12mm 20mm;
    }
    #printable-area .details table th,
    #printable-area .details table td {
        border: none;
    }
    #printable-area .spacl {
        padding-left: 20px;
        padding-right: 5px;
    }
    #printable-area .urTable th {
        font-weight: normal;
    }
    #printable-area .product-item-table th {
        text-align: center;
    }
    #printable-area .brTable th{
        width: 110px;
    }
    #printable-area img.unpaid {
        border: none;
        display: none;
        transform: rotate(-45deg);
        position: absolute;
        left: 66%;
        bottom: 0%;
    }


    /* footer section  */
    #printable-area .signature-line {
        position: relative;
        width: 50%;
        height: 1px;
        border-top: 1px solid #ffffffbf;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    #printable-area .signature-line p {
        margin: 0;
        padding-top: 25px;
    }

    /* Print-specific Styles */
    @media print {
        #printable-area .signature-line {
            width: 30% !important;
        }
    }

</style>
