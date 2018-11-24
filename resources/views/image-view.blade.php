<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Kukudocs JS Document Viewer | KUKUDOCS</title>
        <meta name="author" content="KUKUDOCS">
        <meta name="description"
              content="Kukudocs JS Document Viewer is a Javascript-based web document viewer that does not require a server.">
        <meta name="keywords"
              content="HTML5, javascript, Cloud, Viewer, Document, wysisyg, editor, HTML5 Viewer, Javascript Viewer, document viewer, web editor">

        <link href="./css/jsViewer.css" rel="stylesheet" type="text/css">
    </head>

    <body>

        <div id="header" class="header">
            <div class="container">
                <a href="https://www.kukudocs.com">
                    <div class="logo"><img src="./images/logo.png"></div>
                </a>

                <div class="contact"><span class="title">Kukudocs JS Document Viewer</span><span class="description">Kukudocs JS Document Viewer is a Javascript-based web document viewer that does not require a server.</span>
                </div>
            </div>
        </div>

        <div class="container main-container">
            <input id="files" type="file" name="files[]" multiple="false">
            <button id="upload-btn">Select File</button>
        </div>

        <div id="modal">
            <div id="modal-container"><a id="modal-close-btn"></a>
                <div id="docxjs-wrapper" style="width:100%;height:100%;"></div>
            </div>
        </div>
        
        <div id="parser-loading"></div>

        <!-- Must have jquery library -->
        <script type="text/javascript" src="./scripts/_lib/jquery.1.12.3.min.js"></script>

        <script type="text/javascript" src="./scripts/docxjs/DocxJS.bundle.min.js"></script>
        <script type="text/javascript" src="./scripts/celljs/CellJS.bundle.min.js"></script>
        <script type="text/javascript" src="./scripts/slidejs/SlideJS.bundle.min.js"></script>
        <script type="text/javascript" src="./scripts/pdfjs/PdfJS.bundle.min.js"></script>

        <script type="text/javascript" src="./scripts/JSViewerLoader.js"></script>

    </body>

</html>