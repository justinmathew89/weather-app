import React from 'react';
import Select from 'react-select';
import EventEmitter from "EventEmitter";

class SearchBar extends React.Component{

    state = {
        selection: null,
    }

    handleChange = (selection) => {
        this.setState({selection});
        EventEmitter.emit('getForecastData', this.state.selection);
    }

    render() {
        return (
            <Select
                defaultValue={''}
                options={this.props.citiesList}
                onChange={this.handleChange}
            />
        )
    }
}
export default SearchBar;
