import React from 'react'; 
import apiFetch from '@wordpress/api-fetch';

// Initialize WordPress API fetch
if (apiFetch && typeof apiFetch.use === 'function' && typeof apiFetch.createRootURLMiddleware === 'function') {
    apiFetch.use(apiFetch.createRootURLMiddleware('/wp-json'));
}

const fallbackWidgets = [
    { name: 'Team Member', icon: 'eicon-person', enabled: true },
    { name: 'Heading', icon: 'eicon-heading', enabled: true },
    { name: 'Info Box', icon: 'eicon-info-box', enabled: true }
];

const Widgets = () => {
    const [widgetStates, setWidgetStates] = React.useState([]);
    const [isSaving, setIsSaving] = React.useState(false);

    React.useEffect(() => {
        const fetchWidgets = async () => {
            try {
                const response = await apiFetch({ path: '/brikly/v1/widgets' });
                if (Array.isArray(response)) {
                    setWidgetStates(response);
                } else {
                    setWidgetStates(fallbackWidgets);
                }
            } catch (error) {
                console.error('Failed to fetch widget states:', error);
                setWidgetStates(fallbackWidgets);
            }
        };

        fetchWidgets();
    }, []);

    const toggleWidget = async (index) => {
        const newWidgetStates = [...widgetStates];
        newWidgetStates[index].enabled = !newWidgetStates[index].enabled;
        setWidgetStates(newWidgetStates);

        try {
            setIsSaving(true);
            await apiFetch({
                path: '/brikly/v1/widgets',
                method: 'POST',
                data: { widgets: newWidgetStates }
            });
        } catch (error) {
            console.error('Failed to save widget states:', error);
        } finally {
            setIsSaving(false);
        }
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
            {isSaving && <p>Saving...</p>}
        </div>
    );
};

export default Widgets;
