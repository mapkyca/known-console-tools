# Development Console Tools for Known

This repo contains a collection of console tools for debugging and developing for Known.

These were written in no particular order for my own use, and might be of use to you when 
developing plugins, patches and sites using Known.

This is a placeholder for a whole bunch of plugins... to use:

```
composer require mapkyca/known-console-tools
```

## Requirements

At time of writing you'll need the latest development build of Known, which has Symfony console
application support.

## Usage

Copy or symlink to the directories below so that they appear in ```ConsolePlugins```

## Tools available

* [EntityDump](https://github.com/mapkyca/console-entitydump) A tool for outputting the raw contents of an object as identified by UUID, ID or short url
* [EntityList](https://github.com/mapkyca/console-entitylist) List the UUIDs of the last X entities that match the given search criteria
* [ShowACL](https://github.com/mapkyca/console-showacl) A tool to list the access groups a given user has access to (including those supplied programmatically)
* [TweakEntity](https://github.com/mapkyca/console-tweakentity) A tool to tweak field values on a given entity
* [DumpConfig](https://github.com/mapkyca/console-dumpconfig) Dump the current running config
* [ListUsers](https://github.com/mapkyca/console-listusers) Quickly list system users, or optional admin users
* ... and more


## Warning

I wouldn't recommend having these in place on a live system, as that would likely pose a security risk.

These tools, for example, let you dump entity data etc.

# See

* Author: Marcus Povey http://www.marcus-povey.co.uk

