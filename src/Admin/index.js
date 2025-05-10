import React from 'react';
import ReactDOM from 'react-dom';
import './Admin.css';
import { HashRouter as Router, Route, Switch, NavLink, useLocation, Redirect } from 'react-router-dom';
import Widgets from './Widgets';
import Tools from './Tools';
import Settings from './Settings';
import { __ } from '@wordpress/i18n';

const Navigation = () => {
    const location = useLocation();
    return (
        <nav>
            <ul>
                <li><NavLink to="/settings" activeClassName="active">{__('Settings', 'brikly')}</NavLink></li>
                <li><NavLink to="/widgets" activeClassName="active">{__('Widgets', 'brikly')}</NavLink></li>
                <li><NavLink to="/tools" activeClassName="active">{__('Tools', 'brikly')}</NavLink></li>
            </ul>
        </nav>
    );
};

const AdminPage = () => {
    return (
        <div className="admin-page">
            <Navigation />
            <Switch>
                <Route path="/widgets" component={Widgets} />
                <Route path="/tools" component={Tools} />
                <Route path="/settings" component={Settings} />
                <Route exact path="/">
                    <Redirect to="/settings" />
                </Route>
            </Switch>
        </div>
    );
};

ReactDOM.render(
    <Router>
        <AdminPage />
    </Router>,
    document.getElementById('brikly-admin-root')
);
