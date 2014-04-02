    jsoncons::json_deserializer

    typedef basic_json_deserializer<char,storage<char>> json_deserializer

The `json_deserializer` class is an instantiation of the `basic_json_deserializer` class template that uses char as the character type.

### Header

    #include "jsoncons/json_deserializer.hpp"

### Base classes

[json_input_handler](json_input_handler)

### Constructors

    json_deserializer()

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

### Accessors

    json& root()
Returns a reference to the root of the json value read from the stream
