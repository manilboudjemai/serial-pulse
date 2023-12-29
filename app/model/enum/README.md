# `App\Model\Enum\`

## `Baud`

These baud rates work well with all sorts of devices like microcontrollers, communication modules, and other gadgets that use serial communication.

The baud rate sets the speed for sending data over the serial link.

## `ConnectionState`

Different states of a connection are represented.

This enum is particularly useful for managing and tracking the lifecycle of connections within your application.

## `DataBit`

Enumerates the number of bits used to represent each transmitted character of data in a serial communication link.

## `FlowControl`

Enumerates different types of flow control in data transmission between two devices.

Flow control is a crucial method for preventing errors and ensuring smooth communication between devices that exchange messages.

## `Mode`

Enumerates different modes for opening a connection to the stream of data created between the server and the connected object via the serial port.

`READ_ONLY` is suitable for scenarios where the intention is to read data from the stream.

`WRITE_ONLY` is suitable for scenarios where the intention is to write data to the stream.

`READ_WRITE` is suitable for scenarios where the intention is to read and write data to the stream.

### Adding More Modes

The enum has been designed to be extensible. If additional modes are needed, they can be easily added to the enum to accommodate specific requirements. It aligns with PHP's file handling modes.

Learn more about the different modes available for opening a connection to a stream of data: [PHP fopen Function](https://www.php.net/manual/en/function.fopen.php).

## `OS`

It provides a clear representation of operating systems supported by the application and includes utility methods for getting the currently running OS, retrieving the code for a specific OS, checking if the current OS is a specific OS, etc.

**Warning**: This enum only contains the operating systems that are currently supported by the application.

## `Parity`

Parity is a simple error-checking technique that helps detect transmission errors by adding an extra bit to each byte being transmitted.

Setting the parity type is crucial to ensure compatibility between the transmitting and receiving ends of a communication link.

The choice of parity depends on the specific requirements of your application and the agreement between the communicating devices.

`NONE`; in this mode, no additional parity bit is added, and only the data bits are transmitted without any extra bit for error checking.

`ODD`; in this mode, the total number of bits (including the data bits and the parity bit) set to 1 is configured to be odd.

`EVEN`; in this mode, the total number of bits (including the data bits and the parity bit) set to 1 is configured to be even.

## `StopBit`

A _Stop Bit_ is a special bit used to signal the end of a data packet, indicating the number of bits that mark the conclusion of data transmission.

The choice of stop bit configuration depends on the requirements of your communication protocol and the agreement between communicating devices.

`ONE` is the most common configuration in serial communication where a single bit signals the end of a data packet.

`TWO` allocates additional time for the receiving system to process incoming data, enhancing reliability by providing a longer signal indicating the end of the data packet.
