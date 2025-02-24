<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>
        @if (isset($division) && isset($role) && isset($event))
            QR Codes:{{ $division }}, {{ $role }}, {{ $event }}
        @elseif(isset($division) && isset($role))
            QR Codes:{{ $division }}, {{ $role }}
        @elseif(isset($division) && isset($event))
            QR Codes:{{ $division }}, {{ $event }}
        @elseif(isset($role) && isset($event))
            QR Codes:{{ $role }}, {{ $event }}
        @elseif(isset($division))
            QR Codes:{{ $division }}
        @elseif(isset($role))
            QR Codes:{{ $role }}
        @elseif(isset($event))
            QR Codes: {{ $event }}
        @else
            All QR Codes
        @endif
    </title>
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
        .custom-btn {
            align-items: center;
            appearance: none;
            background-color: #FCFCFD;
            border-radius: 4px;
            border-width: 0;
            box-shadow: rgba(45, 35, 66, 0.4) 0 2px 4px, rgba(45, 35, 66, 0.3) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
            box-sizing: border-box;
            color: #36395A;
            cursor: pointer;
            display: inline-flex;
            font-family: "JetBrains Mono", monospace;
            height: 48px;
            justify-content: center;
            line-height: 1;
            list-style: none;
            overflow: hidden;
            padding-left: 16px;
            padding-right: 16px;
            position: relative;
            text-align: left;
            text-decoration: none;
            transition: box-shadow .15s, transform .15s;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            white-space: nowrap;
            will-change: box-shadow, transform;
            font-size: 18px;
        }

        .custom-btn:focus {
            box-shadow: #D6D6E7 0 0 0 1.5px inset, rgba(45, 35, 66, 0.4) 0 2px 4px, rgba(45, 35, 66, 0.3) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
        }

        .custom-btn:hover {
            box-shadow: rgba(45, 35, 66, 0.4) 0 4px 8px, rgba(45, 35, 66, 0.3) 0 7px 13px -3px, #D6D6E7 0 -3px 0 inset;
            transform: translateY(-2px);
        }

        .custom-btn:active {
            box-shadow: #D6D6E7 0 3px 7px inset;
            transform: translateY(2px);
        }
    </style>
</head>

<body>

    <div id="pdf-content" class="content mx-auto">
        <div class="d-flex justify-content-center w-100">
            <button id="printPageButton" class="custom-btn mt-4 btn-lg w-50" onclick="window.print()">Print or Save
                as PDF</button>
        </div>
        @foreach ($participants->chunk(12) as $participantChunk)
            <div class="mt-4 paper mb-0">
                <div class="row">
                    @foreach ($participantChunk as $participant)
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4 mb-2">
                            <div class="d-flex justify-content-center">
                                {!! QrCode::size(200)->generate($participant->qr_data) !!}
                            </div>

                            <div class="mt-2">
                                <h6 class="text-center">{{ $participant->name }} <span> |
                                        {{ $participant->participant_role }}</span></h6>
                                <div class="" style="font-size: 12px;">
                                    <div class="text-center">{{ $participant->division }}</div>
                                    <div class="text-center">{{ $participant->school }}</div>
                                    <div class="text-center">{{ $participant->event }}</div>
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
