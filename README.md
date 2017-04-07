# Contents

[![Release](https://img.shields.io/packagist/v/icybee/module-contents.svg)](https://github.com/Icybee/module-contents/releases)
[![Build Status](https://img.shields.io/travis/Icybee/module-contents.svg)](http://travis-ci.org/Icybee/module-contents)
[![Code Quality](https://img.shields.io/scrutinizer/g/Icybee/module-contents.svg)](https://scrutinizer-ci.com/g/Icybee/module-contents)
[![Code Coverage](https://img.shields.io/coveralls/Icybee/module-contents.svg)](https://coveralls.io/r/Icybee/module-contents)
[![Packagist](https://img.shields.io/packagist/dt/icybee/module-contents.svg)](https://packagist.org/packages/icybee/module-contents)

The Contents module (`contents`) is the base module for content nodes such as articles or
news. If extends nodes with a body, an excerpt, a subtitle, a date and an additionnal visibility
option. The body can be edited with any of the editors available throught the Editor API.

The rendered body can be cached and the module provides a cache manager for the [Cache](https://github.com/Icybee/module-cache)
module that allows the user to control the cache.





## Requirement

The package requires PHP 5.6 or later.





## Installation

The recommended way to install this package is through [Composer](http://getcomposer.org/).
Create a `composer.json` file and run `php composer.phar install` command to install it:

	$ composer require icybee/module-contents

Note: The module is part of the modules required by Icybee.





### Cloning the repository

The package is [available on GitHub](https://github.com/Icybee/module-contents), its repository can be
cloned with the following command line:

	$ git clone git://github.com/Icybee/module-contents.git contents





## Documentation

The package is documented as part of the [Icybee](http://icybee.org/) CMS
[documentation](http://icybee.org/docs/). The documentation for the package and its
dependencies can be generated with the `make doc` command. The documentation is generated in
the `docs` directory using [ApiGen](http://apigen.org/). The package directory can later be
cleaned with the `make clean` command.





## Testing

The test suite is ran with the `make test` command. [Composer](http://getcomposer.org/) is
automatically installed as well as all the dependencies required to run the suite. The package
directory can later be cleaned with the `make clean` command.

The package is continuously tested by [Travis CI](http://about.travis-ci.org/).

[![Build Status](https://img.shields.io/travis/Icybee/module-contents.svg)](http://travis-ci.org/Icybee/module-contents)
[![Code Coverage](https://img.shields.io/coveralls/Icybee/module-contents.svg)](https://coveralls.io/r/Icybee/module-contents)





## License

The package is licensed under the New BSD License - See the LICENSE file for details.
