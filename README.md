# ShareAI Project

This repository contains a simple prototype implementation for the **ShareAI** platform. The application demonstrates how to connect PHP to the LiteDB database using the COM extension on Windows. It includes minimal user authentication and group creation features.

## Requirements
- PHP 7.4+ on Windows
- .NET Framework with LiteDB.dll registered as a COM object

## Running
1. Clone the repository and ensure `php.ini` has `extension=php_com_dotnet.dll` enabled.
2. Register `LiteDB.dll` with `regasm` so that `LiteDB.LiteDatabase` is available.
3. Place the project in a web server environment and navigate to `public/index.php`.

This is a proof of concept. Further security and feature improvements are required for production use.
