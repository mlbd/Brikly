import React from 'react';

const widgets = [
    { name: 'Team Member', icon: 'eicon-person', enabled: true },
    { name: 'Heading', icon: 'eicon-heading', enabled: true },
    { name: 'Info Box', icon: 'eicon-info-box', enabled: true }
];

const Widgets = () => {
    const [widgetStates, setWidgetStates] = React.useState(widgets);

    const toggleWidget = (index) => {
        const newWidgetStates = [...widgetStates];
        newWidgetStates[index].enabled = !newWidgetStates[index].enabled;
        setWidgetStates(newWidgetStates);
    };

    return (
        <div className="widgets-tab">
            {widgetStates.map((widget, index) => (
                <div key={index} className="widget">
                    <i className={widget.icon}></i>
                    <span>{widget.name}</span>
                    <label>
                        <input
                            type="checkbox"
                            checked={widget.enabled}
                            onChange={() => toggleWidget(index)}
                        />
                        Enable
                    </label>
                </div>
            ))}
        </div>
    );
};

export default Widgets;