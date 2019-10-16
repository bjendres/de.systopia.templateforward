# de.systopia.templateforward

![Screenshot](/images/screenshot.png)

This extension implements page forwards for defined pages. Configuration can be done in Config.php

The extension is licensed under [AGPL-3.0](LICENSE.txt).

## Requirements

* PHP v5.4+
* CiviCRM (*FIXME: Version number*)

## Installation (Web UI)

This extension has not yet been published for installation via the web UI.

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl de.systopia.templateforward@https://github.com/FIXME/de.systopia.templateforward/archive/master.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/FIXME/de.systopia.templateforward.git
cv en templateforward
```

## Usage

- See config file for examples
- parameters must consist of 'forward_target' with an url to forward to
- other paramters need to be URL params, otherwise no forwarding will occur

e.g. civicrm/contact/view?reset=1&cid=1

Parameter could be 'cid' : '1'

If reading a file on every page load eats too much time, consider caching the pararmeters in CRM_TemplateForward_Config::$pages. If values are set, no files are read from /resources/*.json

## Known Issues

Verification parameters only work for URL params
