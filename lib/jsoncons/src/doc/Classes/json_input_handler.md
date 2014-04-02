    jsoncons::json_input_handler

    typedef basic_json_input_handler<char> json_input_handler

The `json_input_handler` class is an instantiation of the `basic_json_input_handler` class template that uses char as the character type. It defines an interface for a listener to JSON events.

### Header

    #include "jsoncons/json_input_handler.hpp"

### Overloaded methods

    void value(const std::string& value, const parsing_context& context)
Send notification of a string value. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    void value(null_type, const parsing_context& context)
Send notification of a null value. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    void value(float value, const parsing_context& context)
Send notification of a float number. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    void value(double value, const parsing_context& context)
Send notification of a double number. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    void value(int value, const parsing_context& context)
Send notification of an int number. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    void value(unsigned int value, const parsing_context& context)
Send notification of an unsigned int number. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    void value(long value, const parsing_context& context)
Send notification of a long number. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    void value(unsigned long value, const parsing_context& context)
Send notification of an unsigned long number. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    void value(long long value, const parsing_context& context)
Send notification of a long long number. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    void value(unsigned long long value, const parsing_context& context)
Send notification of an unsigned long long number. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    void value(bool value, const parsing_context& context)
Send notification of a boolean value. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

### Implementing methods

    virtual void begin_json()
Receive notification of the start of JSON text

    virtual void end_json()
Receive notification of the end of JSON text

    virtual void begin_object(const parsing_context& context)
Receive notification of the start of a JSON object. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    virtual void end_object(const parsing_context& context)
Receive notification of the end of a JSON object. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    virtual void begin_array(const parsing_context& context)
Receive notification of the start of a JSON array. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    virtual void end_array(const parsing_context& context)
Receive notification of the end of a JSON array. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    virtual void name(const std::string& name, const parsing_context& context)
Receive notification of the `name` part of a name-value pair. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter.  

    virtual void null_value(const parsing_context& context)
Receive notification of a null value. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    virtual void null_value(const parsing_context& context)
Receive notification of a null value. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    virtual void string_value(const std::string& value, const parsing_context& context)
Receive notification of a string value. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    virtual void double_value(double value, const parsing_context& context)
Receive notification of a floating point number. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    virtual void longlong_value(long long value, const parsing_context& context)
Receive notification of a signed integer. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    virtual void ulonglong_value(unsigned long long value, const parsing_context& context)
Receive notification of a non-negative integer. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

    virtual void bool_value(bool value, const parsing_context& context)
Receive notification of a boolean value. Contextual information including
line and column information is provided in the [parsing_context](parsing_context) parameter. 

