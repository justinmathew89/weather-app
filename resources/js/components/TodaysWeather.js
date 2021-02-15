import React from 'react';

class TodaysWeather extends React.Component{
    state = {
        name: ''
    }

    render ()
    {
        return (
            <div className="my-4">
                <h3 className="text-center underline">Today's Weather</h3>
                <div className="float-left w-25 px-3">
                    <strong>Minimum: </strong>
                    <br></br>
                    <strong>Maximum: </strong>
                </div>
                <div className="float-left w-25">
                    29 <sup>o</sup>C
                    <br></br>
                    29 <sup>o</sup>C
                </div>
            </div>
        )
    }
}

export default TodaysWeather;
