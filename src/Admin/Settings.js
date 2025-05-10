import './Settings.css';
import React from 'react';

const Settings = () => {
    return (
        <div className="settings-tab">
            <h2>Settings</h2>
            <div className="settings-grid">
                <div className="settings-card">
                    <h3>General Settings</h3>
                    <div className="settings-field">
                        <label>Site Title</label>
                        <input type="text" placeholder="Enter site title" />
                    </div>
                    <div className="settings-field">
                        <label>Description</label>
                        <textarea placeholder="Enter site description" rows="3"></textarea>
                    </div>
                </div>
                
                <div className="settings-card">
                    <h3>Widget Settings</h3>
                    <div className="settings-field">
                        <label>
                            <input type="checkbox" />
                            Enable Widget Animations
                        </label>
                    </div>
                    <div className="settings-field">
                        <label>Animation Speed</label>
                        <select>
                            <option value="slow">Slow</option>
                            <option value="normal">Normal</option>
                            <option value="fast">Fast</option>
                        </select>
                    </div>
                </div>

                <div className="settings-card">
                    <h3>Advanced Options</h3>
                    <div className="settings-field">
                        <label>Cache Duration (hours)</label>
                        <input type="number" min="1" max="24" defaultValue="12" />
                    </div>
                    <div className="settings-field">
                        <label>
                            <input type="checkbox" />
                            Enable Debug Mode
                        </label>
                    </div>
                </div>
            </div>
            <button className="settings-button" style={{ marginTop: '2rem' }}>Save Changes</button>
        </div>
    );
};

export default Settings;