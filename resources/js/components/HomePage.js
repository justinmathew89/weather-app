import React, {useEffect} from 'react';
import ReactDOM from 'react-dom';

import SearchBar from "./SearchBar";
import TodaysWeather from "./TodaysWeather";
import ForecastWeather from "./ForecastWeather";
import isobject from "isobject";
import {isString} from "lodash";

class HomePage extends React.Component{

    state = {
        citiesList : [],
        todaysWeather : [],
        forecastWeather : []
    }

    componentDidMount() {
        // fetches forcast data for the page initially
        this.getForecastData('Sydney');
    }

    getForecastData(value=null) {
        var cityname = '';
        if (value && isobject(value))
        {
            cityname = "?cityname="+value.city+"&cityId="+value.value;
        }
        else if(isString(value))
        {
            cityname = "?cityname="+value;
        }
        fetch("/api/forecast"+cityname)
            .then(res => res.json())
            .then(
                (result) => {
                    if (result['status_code'] == 0)
                    {
                        // setting up todays weather
                        this.setState({todaysWeather: result['current_weather']});

                        // setting up weather for next 5 days
                        this.setState({forecastWeather: result['forecast_weather']});
                    }
                    else
                    {
                        alert('Some error occured while fetching weather details');
                    }
                },
                (error) => {
                    alert('Some error occured while fetching weather details');
                }
            )
    }

    render () {
        return (
            <div className="container overflow-hidden">
                <SearchBar
                // citiesList = {this.state.citiesList}
                getForecastData = {this.getForecastData.bind(this)}
                />
                <TodaysWeather
                    todaysWeather = {this.state.todaysWeather}
                />
                <ForecastWeather
                    forecastWeather = {this.state.forecastWeather}
                />
            </div>
        )
    }

}

export default HomePage;

if (document.getElementById('homePage')) {
    ReactDOM.render(<HomePage />, document.getElementById('homePage'));
}
