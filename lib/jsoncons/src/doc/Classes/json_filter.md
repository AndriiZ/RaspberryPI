    jsoncons::json_filter

    typedef basic_json_filter<char> json_filter

The `json_filter` class is an instantiation of the `basic_json_filter` class template that uses char as the character type.

### Header

    #include "jsoncons/json_filter.hpp"

### Base classes

[json_input_handler](json_input_handler)

### Constructors

    json_filter(json_input_handler& parent)

    json_filter(json_output_handler& output_handler)

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

    json_input_handler& parent()
Returns a reference to the parent input handler. 
