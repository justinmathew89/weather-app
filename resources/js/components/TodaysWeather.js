import React from 'react';

class TodaysWeather extends React.Component{
    state = {
        name: ''
    }

    render ()
    {
        return (
            <div className="my-4 overflow-hidden">
                <h2 className="text-center underline">Today's Weather</h2>
                <div className="float-left w-1/2 px-3">
                    <h3>{this.props.todaysWeather['weather']}</h3>
                    <i className="fa fa-arrow-up"></i> &nbsp; {this.props.todaysWeather['maxTemperature']} <sup>o</sup>C<br />
                    <i className="fa fa-arrow-down"></i> &nbsp; {this.props.todaysWeather['minTemperature']} <sup>o</sup>C<br />
                    <i className="fa fa-wind"></i> &nbsp; {this.props.todaysWeather['windspeed']} Kmph<br />
                </div>
                <div className="float-left w-1/2">
                    Current Temp<br />
                    <span className="text-4xl">{this.props.todaysWeather['currentTemperature']} <sup>o</sup>C</span> <br />
                    Feels Like<br />
                    <span className="text-2xl">{this.props.todaysWeather['currentTemperatureFeelsLike']} <sup>o</sup>C</span><br />
                </div>
            </div>
        )
    }
}

export default TodaysWeather;
