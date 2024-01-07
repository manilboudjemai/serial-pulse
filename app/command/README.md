# `App\Command\`

## `CreateSerialConnection`

This command serves as the primary function of the application, allowing the creation of a serial connection to a device and the transmission of data.

The process is interactive, requiring the user to provide the following information for setting up the serial connection:

+ Serial port selection
+ Baud rate (must match the device)
+ Number of data bits (must match the device)
+ Flow control mechanism
+ Parity configuration (must match the device)
+ Number of stop bits (must match the device)
+ Wait time between each transmission (in seconds)

Upon successfully establishing a connection, the sub-command `SendData` is executed to send data to the connected device.

## `SendData`

This sub-command facilitates the transmission of data to the device and is executed by the main command `CreateSerialConnection` after a successful connection.

The process is interactive, prompting the user for the data to be sent to the device.

Data is transmitted byte by byte, and the user is provided with real-time progress updates during the transmission.
