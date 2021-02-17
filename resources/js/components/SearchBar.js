import React from 'react';
import Select from 'react-select';

class SearchBar extends React.Component{

    state = {
        selection: null,
    }

    handleChange = (selection) => {
        this.setState({selection})
        this.props.getForecastData(selection)
    }

    render() {
        return (
            <Select
                defaultValue={{label:'Sydney'}}
                options={this.props.citiesList}
                onChange={this.handleChange}
            />
        )
    }
}
export default SearchBar;
