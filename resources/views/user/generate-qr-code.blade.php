<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Print ID</title>
    <meta name="csrf-token" content="bB0FvSfkMmZzQs8mqjq8sIhFMBg5HJsMGkbKLB4p">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        @media print {

            #printPageButton,
            #downloadPdfButton {
                display: none;
            }
        }

        @media print {
            @page {
                size: auto;
                /* Automatically adjust to the paper size */
                margin: 10mm;
                /* Set a minimal margin for better fit */
            }

            body {
                margin: 0;
                padding: 0;
                align-items: center;
            }

            .paper {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
                /* Ensures proper column sizing */
                gap: 10px;
                justify-content: center;
                align-items: start;
                max-width: 8.5in;
                page-break-inside: avoid;
            }

            .meet-id {
                width: 100%;
                max-width: 50%;
                /* Increase max width for better spacing */
                padding: 10px;
                box-sizing: border-box;
                /* border: 1px solid #ccc; */
                text-align: center;
                page-break-inside: avoid;
            }

            /* Prevent breaking in the middle */
            .meet-id:nth-child(4n) {
                page-break-after: avoid;
            }
        }


        .paper {
            width: 8.5in;
            max-height: 14in;
            padding: .2in;
            margin: 1in auto;
            /* border: 1px #D3D3D3 solid; */
            border-radius: 5px;
            background: white;
            /* box-shadow: 0 0 5px rgba(0, 0, 0, 0.1); */
        }

        .content {
            width: 8.5in;
            max-height: 14in;
        }
    </style>
</head>

<body>

    <div id="pdf-content" class="content mx-auto">
        <div class="d-flex justify-content-center w-100">
            <button id="printPageButton" class="btn btn-success mt-4 btn-lg w-50" onclick="window.print()">Print or Save as PDF</button>
        </div>
        @foreach ($participants->chunk(2) as $participantChunk)
            <div class="mt-4 paper mb-0">
                <div class="row">
                    @foreach ($participantChunk as $participant)
                        <div class="col-sm-6 meet-id">
                            <div class="card">
                                <div class="card-body">
                                    <table cellpadding="5" class="text-center" width="100%">
                                        <tr>
                                            <td>
                                                <span class="h4">SRAA MEET 2025</span>
                                                <span class="sub">
                                                    <br />SOCCSKSARGEN Region
                                                    <br /> Schools Division of Koronadal City
                                                    <br /> February 17-24, 2025
                                                </span>
                                                <br /><br /><span class="h3">PARTICIPANT</span>
                                                <br /><span
                                                    class="h5">{{ $participant->participant_role == 'student' ? 'player' : $participant->participant_role }}</span>
                                                <br /><img src="{{ asset('image/placeholder.png') }}" width="96px"
                                                    height="96px"></span>
                                                <br /><br />
                                                {!! QrCode::size(100)->generate($participant->participant_id) !!}
                                                <br /><span class="fst-italic">{{ $participant->participant_id }}</span>
                                                <br /><br />
                                                <span class="h5">{{ $participant->name }}</span>
                                                <br /> <span class="h6 text-muted">{{ $participant->division }}</span>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

</body>

</html>
