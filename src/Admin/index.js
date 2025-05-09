import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Switch, NavLink } from 'react-router-dom';
import Widgets from './Widgets';
import Tools from './Tools';
import Settings from './Settings';
import { __ } from '@wordpress/i18n';

const AdminPage = () => {
    return (
        <Router>
            <div className="admin-page">
                <nav>
                    <ul>
                        <li><NavLink to="/widgets" activeClassName="active">{__('Widgets', 'brikly')}</NavLink></li>
                        <li><NavLink to="/tools" activeClassName="active">{__('Tools', 'brikly')}</NavLink></li>
                        <li><NavLink to="/settings" activeClassName="active">{__('Settings', 'brikly')}</NavLink></li>
                    </ul>
                </nav>
                <Switch>
                    <Route path="/widgets" component={Widgets} />
                    <Route path="/tools" component={Tools} />
                    <Route path="/settings" component={Settings} />
                </Switch>
            </div>
        </Router>
    );
};

ReactDOM.render(<AdminPage />, document.getElementById('brikly-admin-root'));