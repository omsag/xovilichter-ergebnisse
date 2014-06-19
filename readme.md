###Die Ergebnisse des Xovilichterwettbewerbs als Wordpress Plugin

Du nimmst am Xovilichterwettbewerb teil? Dann hol dir die Ergebnissliste des Xovilichterwettbewerbs in deinen Wordpress-Blog.

######Beispielansicht:

![Beispielausgabe](http://i.imgur.com/PMC1Nz7.png)

Nutzung
---
Zum Einbinden in einen Beitrag bzw. eine Seite kann der folgende Shortcode benutzt werden:
```
[xovilichterErgebnisse]
```
Hierbei werden alle 150 Ergebnisse ausgegeben, welche auf der Ergebnisseite von Xovi angegeben sind.

Folgende Variationen sind ebenfalls noch möglich:

* ```[xovilichterErgebnisse zeige="10"]``` Zeigt die ersten 10 Ergebnisse an.
* ```[xovilichterErgebnisse zeige="10" ab="5"]``` Zeigt 10 Ergebnisse ab Platz 5 an.

### Konfiguration
In der Date ```XovilichterErgebnisse.php``` muss in ```Zeile 26``` der Link zur Ergebnisseite von Xovi eingetragen werden.

In Aktion kann das Plugin auf der [Xovilichter Contest-Seite der OMS AG](http://www.omsag.de/xovilichter/) betrachtet werden.