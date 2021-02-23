import React from 'react';
import AsyncSelect from 'react-select/async';
import _ from "lodash";


class SearchBar extends React.Component{

    state = {
        citiesList: [{label : 'Sydney, Australia',city:'Sydney',country : 'Australia'}]
    }

    mapOptionsToValues = options => {
        return options.map(option => ({
            country: option.country,
            label: option.name
        }));
    };

    getCityListData(query = "", callback) {
        // alert(this.state.citiesList);
        if (query !== '')
        {
            query = '/'+query;
        }

        const that = this;
        return fetch("/api/city"+query)
            .then(res => res.json())
            .then(
                (result) => {
                    that.setState({'citiesList':result})
                    return result;
                },
                (error) => {
                    alert('Some error occured');
                }
            );
    };

    handleChange = (selection) => {
        this.setState({selection})
        this.props.getForecastData(selection)
    };

    render() {
        return (
            <AsyncSelect
                cacheOptions
                loadOptions={(input) => this.getCityListData(input)}
                onChange={(selection) =>this.handleChange(selection)}
                options={this.props.citiesList}
                defaultValue={this.state.citiesList}
            />
        );
    };
}

export default SearchBar;
