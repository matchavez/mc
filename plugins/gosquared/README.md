# GoSquared for Grav

This is a [Grav](http://getgrav.org) plugin that adds the [GoSquared Analytics](https://gosquared.com) tracking code to Grav pages.

## Installation

Installing the GoSquared plugin can be done in one of two ways.

### Admin Installation (Preferred)
If you have the [GRAV Admin plugin](https://getgrav.org/downloads/plugins) installed (and you really should ) you can install this plugin from your browser. Simply login to your Admin area, click on "Plugins" in the left sidebar menu, the click on `+ Add` in the top right of the Plugins view.

Simply scroll to the GoSquared Analytics plugin (or filter by name) and then click `+ Install` on the right end of the row for the plugin.

### GPM Installation

The simplest way to install this plugin is via the [Grav Package Manager (GPM)](http://learn.getgrav.org/advanced/grav-gpm) through your system's Terminal (also called the command line).  From the root of your Grav install type:

`bin/gpm install gosquared`

This will install the GoSquared plugin into your `/user/plugins` directory within Grav. The plugin files should now be in `/your/site/grav/user/plugins/gosquared`

### Manual Installation

To install this plugin, just [download](https://github.com/cppl/grav-gosquared/archive/master.zip) the zip version of this repository and unzip it under `/your/site/grav/user/plugins`. Then, rename the folder to `gosquared`.

You should now have all the plugin files under

    /your/site/grav/user/plugins/gosquared

## Config Defaults

Prior to the [Admin plugin](https://github.com/getgrav/grav-plugin-admin) you could modify a plugins yaml file directly (you still can actually) but now the Admin screens offer a much easier and safer way to adjust the plugins settings.

The `gosquared.yaml` contains only 3 settings:

```
enabled: true  
gsn: ''  
gsInAdmin: false
```

If you need to change any value, I recommend using the Admin screens available via the Admin plugin . This will let you change any of the settings and provide a useful tooltip for each setting (hover over the settings label).

## Usage

1. In your GoSquared account, open the domain you're using Grav on (or add one if needed).
2. At the bottom of the left side menu you will find *Settings* — click on it.
3. Copy the *GoSquared Site Token* and paste it into the settings for the plugin (I recommend **pasting** not typing...)
