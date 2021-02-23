import React from 'react';

class ForecastWeather extends React.Component{
    state = {
        name: ''
    }

    render ()
    {
        return(
            this.props.forecastWeather.map((weather,i) => {
                return (
                    <div className="px-1 grid-cols-4 w-1/5 py-3 float-left" >
                        <h3 className="content-center underline">{weather['date']}</h3>
                        <h3 className="center-align py-1">{weather['weather']}</h3>
                        <p><i className="fa fa-arrow-up"></i> {weather['maxTemperature']} <sup>o</sup>C</p>
                        <p><i className="fa fa-arrow-down"></i> {weather['minTemperature']} <sup>o</sup>C</p>
                        <p><i className="fa fa-wind"></i> {weather['windspeed']} Kmph</p>
                    </div>
                );
            })
        );
    }
}

export default ForecastWeather;
