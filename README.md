# SerialPulse

This application is an experimental project utilizing [PHP](https://github.com/php/php-src), a server-side language, for establishing serial communication with a connected device through a serial port.

It provides a CLI interactive experience, enabling users to configure a connection and transmit data over the serial port.

## Features

### CLI Interactivity

The application currently exposes a single command to the user : `app:serial-connect`.

This command initiates an interactive process, allowing users to configure and establish a connection while progressively sending data to the connected device byte by byte.

## How to Use

Ensure you have **PHP 8.2.13 or higher** installed in your environment.

Open a CLI interface and locate yourself at the root of the application's directory structure.

Run the following command to initiate the application : `php index.php app:serial-connect`. This launches an interactive process for configuring the connection and sending data.

To view all available commands, use `php index.php list`.

## Adding New Commands

Develop a new `App\Command` class in the `app/command` directory; e.g. `NewCommand.php`.

Add the new command class to the application by including `$app->add(new NewCommand());` in the `index.php` file, the main entry point of the application.

## Considerations

### Stateless Nature

As PHP is inherently stateless, a new connection needs to be configured and established every time data is sent. Future enhancements are planned to introduce a solution that retains connection configuration settings across requests, streamlining the process of sending data via the serial port.

### Connection Configuration

Ensure that connection configurations match those set on the connected device, including baud rate, data bits, parity, and stop bit, to ensure proper communication.

### Windows Limitations

Due to Windows architecture and PHP's single-threaded nature, duplex communication is not supported on Windows OS. Contributions to extend support to other operating systems are welcome.

## Limitations

The application is currently only supported on Windows operating systems.

## User Agreement

This software is provided "as is" without warranty. Users assume the risk of its quality and performance.

You may copy, distribute, and modify the software under the GNU General Public License.

## Credits

This project utilizes the following libraries to enhance its functionality :

+ [symfony/console](https://github.com/symfony/console) for building the CLI interactive experience for users.
+ [sebastianbergmann/phpunit](https://github.com/sebastianbergmann/phpunit) for ensuring the reliability and quality of the application.
