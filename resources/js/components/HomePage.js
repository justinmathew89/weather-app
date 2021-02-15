import React, {useEffect} from 'react';
import ReactDOM from 'react-dom';
import EventEmitter from "EventEmitter";

import SearchBar from "./SearchBar";
import TodaysWeather from "./TodaysWeather";

class HomePage extends React.Component{

    state = {
        citiesList : []
    }

    componentDidMount() {
        this.getCityListData();
    }

    getCityListData() {
        fetch("/api/city")
            .then(res => res.json())
            .then(
                (result) => {
                    this.setState({citiesList:result})
                },
                (error) => {
                    alert('Error');
                }
            )
    }

    getForecastData(value) {
        alert(value);
    }

    render () {
        return (
            <div className="container">
                <SearchBar
                citiesList = {this.state.citiesList}
                />
                <TodaysWeather />
            </div>
        )
    }



}

useEffect(() => {
    EventEmitter.subscribe('getForecastData', (event) => {console.log('herhe')})
});

export default HomePage;

if (document.getElementById('homePage')) {
    ReactDOM.render(<HomePage />, document.getElementById('homePage'));
}
