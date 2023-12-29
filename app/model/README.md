# `App\Model\`

## `SerialConnector`

The `SerialConnector` class provides an interface for serial communication between a computer and a device.

It facilitates the setup, opening, and closing of serial connections, allowing data transmission between the computer and a connected device through a specified serial port.

Users can configure various parameters such as baud rate, data bits, flow control, parity, stop bits, and transmission wait time.

The class performs cleanup operations when an instance is destructed, ensuring that the serial connection is closed, and the configuration process is terminated.

**Ensure that the operating system is supported before using the class. Currently, only Windows is supported**.

## `SerialConfig`

The `SerialConfig` class represents a serial configuration, encapsulating settings such as the port name, baud rate, data bit setting, flow control, parity type, and stop bit configuration for a serial connection.

The `SerialConfig` class is designed to represent a static configuration and is typically used as part of setting up a `SerialConnector`.

## `SerialConnection`

The class represents a serial connection, providing functionalities to manage the state, stream, ID, and type of the connection.

It encapsulates the complexity of managing the connection's lifecycle, including opening, writing data, and closing the serial connection.

The class is designed to be part of a larger system, working in conjunction with the `SerialConnector` and `SerialConfig` classes to facilitate serial communication.
