from http.server import BaseHTTPRequestHandler, HTTPServer

class MyServer(BaseHTTPRequestHandler):
    def do_GET(self):
        # Handle GET requests as before
        self.send_response(200)
        self.send_header('Content-type', 'text/html')
        self.end_headers()
        with open('localization_button.html', 'rb') as f:
            self.wfile.write(f.read())

    def do_POST(self):
        # Handle POST requests
        content_length = int(self.headers['Content-Length'])
        post_data = self.rfile.read(content_length)
        # Process the received data (e.g., save to a file)
        print(post_data) 
        self.send_response(200)
        self.end_headers()
        self.wfile.write(b'POST request received.') 

if __name__ == '__main__':
    hostName = 'localhost'
    serverPort = 8080 

    webServer = HTTPServer((hostName, serverPort), MyServer)
    print("Server started http://%s:%s" % (hostName, serverPort))

    try:
        webServer.serve_forever()
    except KeyboardInterrupt:
        pass

    webServer.server_close()
    print("Server stopped.")
