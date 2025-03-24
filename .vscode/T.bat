T
ask: First Connect
platform: win32
arch: x64

[Error]
message: Login incorrect.[530]
code: 530

[Stack Trace]
Error: Login incorrect.
    at makeError (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\node_modules\ftp\lib\connection.js:1067:13)
    at Parser.<anonymous> (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\node_modules\ftp\lib\connection.js:113:25)
    at Parser.emit (node:events:518:28)
    at Parser._write (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\node_modules\ftp\lib\parser.js:59:10)
    at writeOrBuffer (node:internal/streams/writable:572:12)
    at _write (node:internal/streams/writable:501:10)
    at Parser.Writable.write (node:internal/streams/writable:510:10)
    at Socket.ondata (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\node_modules\ftp\lib\connection.js:273:20)
    at Socket.emit (node:events:518:28)
    at addChunk (node:internal/streams/readable:561:12)
    at readableAddChunkPushByteMode (node:internal/streams/readable:512:3)
    at Socket.Readable.push (node:internal/streams/readable:392:5)
    at TCP.onStreamRead (node:internal/stream_base_commons:191:23)
    at Object.promiseErrorWrap (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\src\util\util.ts:247:16)
    at FtpConnection.connect (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\src\vsutil\fileinterface.ts:39:10)
    at c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\src\ftpmgr.ts:216:45
    at Generator.next (<anonymous>)
    at c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\out\ftpmgr.js:7:71
    at new Promise (<anonymous>)
    at __awaiter (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\out\ftpmgr.js:3:12)
    at tryToConnect (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\out\ftpmgr.js:175:24)
    at FtpManager.<anonymous> (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\src\ftpmgr.ts:298:11)
    at Generator.next (<anonymous>)
    at c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\out\ftpmgr.js:7:71
    at new Promise (<anonymous>)
    at __awaiter (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\out\ftpmgr.js:3:12)
    at FtpManager.connect (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\out\ftpmgr.js:160:16)
    at FtpCacher.<anonymous> (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\src\ftpcacher.ts:579:23)
    at Generator.next (<anonymous>)
    at c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\out\ftpcacher.js:7:71
    at new Promise (<anonymous>)
    at __awaiter (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\out\ftpcacher.js:3:12)
    at c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\src\ftpcacher.ts:578:21
    at c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\src\ftpcacher.ts:598:6
    at Scheduler.task (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\src\vsutil\work.ts:302:11)
    at FtpCacher.ftpList (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\src\ftpcacher.ts:565:25)
    at FtpCacher.<anonymous> (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\src\ftpcacher.ts:147:15)
    at Generator.next (<anonymous>)
    at c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\out\ftpcacher.js:7:71
    at new Promise (<anonymous>)
    at __awaiter (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\out\ftpcacher.js:3:12)
    at TaskImpl.task (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\src\ftpcacher.ts:146:61)
    at TaskImpl.<anonymous> (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\src\vsutil\work.ts:98:21)
    at Generator.next (<anonymous>)
    at c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\out\vsutil\work.js:7:71
    at new Promise (<anonymous>)
    at __awaiter (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\out\vsutil\work.js:3:12)
    at TaskImpl.play (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\out\vsutil\work.js:67:16)
    at Scheduler.progress (c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\src\vsutil\work.ts:337:21)
    at c:\Users\Mar\.vscode\extensions\fftp.ftp-kr-1.4.1\src\vsutil\work.ts:338:43
    at processTicksAndRejections (node:internal/process/task_queues:95:5)

[ftp-kr.json]
{
    "host": "mppt.pl",
    "username": "fxelect",
    "password": "********",
    "remotePath": "",
    "protocol": "ftp",
    "port": 0,
    "fileNameEncoding": "utf8",
    "autoUpload": true,
    "autoDelete": false,
    "autoDownload": false,
    "ignore": [
        ".git",
        "/.vscode"
    ]
}