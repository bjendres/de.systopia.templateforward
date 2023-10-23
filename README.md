# de.systopia.templateforward
Extension to enable forwarding on specific pages

## Usage

- See config file for examples
- parameters must consist of 'forward_target' with an url to forward to
- other parameters need to be URL params, otherwise no forwarding will occur

e.g. civicrm/contact/view?reset=1&cid=1

Parameter could be 'cid' : '1'

If reading a file on every page load eats too much time, consider caching the parameters in CRM_TemplateForward_Config::$pages. If values are set, no files are read from /resources/*.json

## Known Issues

Verification parameters only work for URL params
