# Arma 3 Altis Life Database Webinterface

## Inhalt

* Installation
* Rechte
* Lizenz

## Installation

Um das Webinterface nutzen zu können muss die ```database.sample.php``` angepasst - *Host*, *Datenbank*, *Benutzer*, *Passwort* etc. - und als ```database.php``` gespeichert werden. Des Weiteren können die *Coplevel*, *Mediclevel*, *ADAC-Level*, *Lizenzen*, *Skilllevel* und *Fahrzeuge* in den entsprechenden JSON-Dateien unter ```app/views/jsons/``` angepasst werden. Alle weiteren Änderungen müssen derzeit noch direkt im Code gemacht werden.

## Rechte

|                        | Super-Admin             | Admin                   | Support III             | Support II              | Support I               | Mitglied                |
|------------------------|-------------------------|-------------------------|-------------------------|-------------------------|-------------------------|-------------------------|
| Rechte-Level verändern | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/error.jpg) | ![ja](/icons/error.jpg) | ![ja](/icons/error.jpg) | ![ja](/icons/error.jpg) |
| Spieler Level          | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/error.jpg) |
| Spieler Lizenzen       | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/error.jpg) | ![ja](/icons/error.jpg) |
| Spieler Geld           | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/error.jpg) | ![ja](/icons/error.jpg) | ![ja](/icons/error.jpg) |
| Spieler Donator        | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/error.jpg) | ![ja](/icons/error.jpg) | ![ja](/icons/error.jpg) |
| Spieler Admin          | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/error.jpg) | ![ja](/icons/error.jpg) | ![ja](/icons/error.jpg) | ![ja](/icons/error.jpg) |
| Fahrzeuge              | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/check.jpg) | ![ja](/icons/error.jpg) | ![ja](/icons/error.jpg) |

## Lizenz

The [MIT License](http://opensource.org/licenses/MIT) (MIT)

Copyright (c) 2015 [Tom Witkowski](https://github.com/Gummibeer)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the "Software"), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.