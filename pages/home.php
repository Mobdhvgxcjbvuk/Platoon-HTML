<!DOCTYPE html>
<html lang="en">
<head>
  <base href="../" target="_blank">
  <meta charset="UTF-8">
  <meta name="viewport" content=
  "width=device-width, initial-scale=1.0">
  <title>HTML File Loader</title>
  <meta name="description" content=
  "Import an HTML file and it will launch the file in a new tab.">
  <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        header {
            background-color: #007BFF;
            color: white;
            padding: 20px;
            text-align: center;
        }
        #container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        input[type="file"] {
            margin: 20px;
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        button {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #218838;
        }
        .message {
            margin-top: 20px;
            font-size: 14px;
            color: #888;
        }
  </style>
</head>
<body>
  <header>
    <h1>HTML File Loader</h1>
  </header>
  <div id="container">
    <input type="file" id="fileInput" accept=".html"> <button id=
    "launchBtn" onclick="launch();">Launch</button>
    <div class="message" id="message"></div>
  </div>
  <script>
        var url = '';  // Global variable to hold the file URL

        document.getElementById("fileInput").addEventListener("change", function(event) {
            var file = event.target.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    // Create a Blob from the file content
                    var blob = new Blob([e.target.result], { type: "text/html" });
                    url = URL.createObjectURL(blob);  // Set the global url variable
                    document.getElementById("message").textContent = "File loaded successfully!";
                };
                // Read the file as text
                reader.readAsText(file);
            }
        });

        function launch() {
            if (url) {
                var win = window.open();
                win.document.body.style.margin = "0px";
                var iframe = win.document.createElement("iframe");
                iframe.style.width = "100%";
                iframe.style.height = "100%";
                iframe.style.border = "none";
                iframe.src = url;
                win.document.body.appendChild(iframe);
            } else {
                document.getElementById("message").textContent = "Please select a file first.";
            }
        }
  </script>
</body>
</html>