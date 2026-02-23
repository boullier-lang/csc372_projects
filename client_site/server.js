//Mathew Boullier
//Date: 2/22/2026
//A simple NODE.JS file that acts as the server.

//Variety of file management modules
const http = require('http');
const path = require('node:path');
const fs = require('fs');

const PORT = 3000;


function displayContent(res, filePath, type, statusCode)
{
	if(!res){
		res=200; //No response, assume we are okay :)
	}
	
	//Display the content; error to 500 if we somehow made it this far and we cannot display.
    fs.readFile(filePath, (err, data) => {
        if (err) {
            res.writeHead(500, {"Content-Type": "text/plain"});
            res.end("error code 500, failed to load " + filePath);
        } else {
            res.writeHead(statusCode, {"Content-Type": type});
            res.end(data);
        }
    });
}

const server = require('http').createServer((req, res) => {
    let url_path = req.url.split("?")[0].replace(/\/+$/, "").toLowerCase();

    if (url_path === "") url_path = "/home_page.html";
	
	//Create a map so we can map our file extensions to the correct content-type.
	//Originally, I was going to use a switch-statement, but then I found out they cascade and so they are basically worthless.
	//I am now vehemently against switch statements in javascript, they ruined the whole point of switch statements
	const out_types = {
		".css": "text/css",
		".js": "text/javascript",
		".jpeg": "image/jpeg",
		".jpg": "image/jpg",
		".png": "image/png"
	}
	
	//New, clean, un-redundant way to map our correct content_type. We use ?? as the 'default' (when the string is not a key in 'out_types')
	let content_type = out_types[path.extname(url_path)] ?? "text/html";


	//Build our path
    const true_path = path.join(__dirname, "public", url_path);

    const fs = require('fs');
	
    fs.access(true_path, fs.constants.F_OK, (err) => {
        if (err) {
			//Print out the path to see why we failed
			console.log(true_path);
			
            displayContent(res, path.join(__dirname, "public", "404.html"), "text/html", 404);
        } else {
            displayContent(res, true_path, content_type, 200);
        }
    });
});


server.listen(PORT, () => {
  console.log('Server running on: http://localhost:' + PORT);
});