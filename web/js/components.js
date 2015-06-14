var AddOrganizationForm = React.createClass({
    handleSubmit: function(e) {
        e.preventDefault();
        var name = React.findDOMNode(this.refs.name).value;
        this.props.onFormSubmit(name);
        React.findDOMNode(this.refs.name).value = '';
    },
    render: function() {
        return (
            <form className="form-inline commentForm" onSubmit={this.handleSubmit}>
                <h1>Add an Organization</h1>
                <h3 ref="message">{this.props.message} </h3>
                Organization name: <input className="form-control" ref="name"/>
                <input type="submit" value="Add" className="btn btn-primary" />
            </form>
        );
    }
});

var Status = React.createClass({
    getInitialState: function() {
        return {currentIncidents: [], stats: {}};
    },
    componentDidMount: function() {
        this.fetchCurrentIncidents();
        this.fetchStats();
    },
    fetchCurrentIncidents: function() {
        $.ajax({
            url: '/organizations/'+this.props.id+'/incidents/now',
            dataType: 'json',
            cache: false,
            success: function(data) {
                this.setState({currentIncidents: data});
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(status, err.toString());
            }.bind(this)
        });
    },
    fetchStats: function() {
        $.ajax({
            url: '/organizations/'+this.props.id+'/stats',
            dataType: 'json',
            cache: false,
            success: function(data) {
                this.setState({stats: data});
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(status, err.toString());
            }.bind(this)
        });
    },
    render: function() {
        return (
            <span>
            {
                this.state.currentIncidents.length > 0
                    ?
                    <span>
                        <span className="label label-warning">
                            <MinutesAgo date={new Date(this.state.currentIncidents[0].start*1000)} />
                            :&nbsp;
                            {this.state.currentIncidents[0].description}
                        </span>
                        &nbsp; Average downtime: {this.state.stats.averageIncidentDuration}
                    </span>
                    :
                    <span className="label label-success">Everything is fine</span>
            }
            </span>
        );
    }
});

var Organization = React.createClass({
    onRemove: function(e) {
        this.props.onDelete(this.props.id);
    },
    render: function() {
        return (
            <div className="well">
                <h4>{this.props.name} <small>id:{this.props.id}</small></h4>
                {
                    this.props.readOnly == "true"
                        ?
                        <span>
                        <button onClick={this.onRemove} className="btn btn-default pull-right">
                            Remove
                        </button>
                        <IncidentControl organizationId={this.props.id} />
                        </span>
                        :
                        <Status id={this.props.id} />
                }

            </div>
        );
    }
});

var OrganizationList = React.createClass({
    render: function() {
        var props = this.props;
        var nodes = props.data.map(function (organization) {
            return (
                <Organization
                    name={organization.name}
                    id={organization.id}
                    onDelete={props.onDelete}
                    readOnly={props.readOnly}
                />
            );
        });
        return (
            <div>
                <h1>Organizations</h1>
                {nodes}
            </div>
        );
    }
});

var OrganizationBox = React.createClass({
    getInitialState: function() {
        return {message: '', organizations: []};
    },
    componentDidMount: function() {
        this.fetchOrganizations();
    },
    fetchOrganizations: function () {
        $.ajax({
            url: '/organizations',
            dataType: 'json',
            cache: false,
            success: function(data) {
                this.setState({message: this.state.message, organizations: data});
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(status, err.toString());
            }.bind(this)
        });
    },
    handleSubmit: function(name) {
        if (!name) {
            return;
        }
        var component = this;
        $.post( "/admin/organizations", {'name': name})
            .done(function() {
                component.setState({message: 'Organization added'});
                component.fetchOrganizations();
            }).fail(function() {
                component.setState({message: 'Error'});
            });
    },
    handleDelete: function(id) {
        var component = this;
        $.ajax({ url: "/admin/organizations/"+id, type: 'DELETE'})
            .done(function() {
                component.fetchOrganizations();
            }).fail(function() {
                alert("Cannot remove organization");
            });
    },
    render: function () {
        return (
            <span>
                {
                    this.props.readOnly == "true"
                    ? <AddOrganizationForm onFormSubmit={this.handleSubmit} message={this.state.message}/>
                    : null
                }

                <OrganizationList readOnly={this.props.readOnly} onDelete={this.handleDelete} data={this.state.organizations} />
            </span>
        )
    }
});



var IncidentControl = React.createClass({
    getInitialState: function() {
        return {currentIncidents: []};
    },
    componentDidMount: function() {
        this.fetchCurrentIncidents();
    },
    fetchCurrentIncidents: function() {
        $.ajax({
            url: '/organizations/'+this.props.organizationId+'/incidents/now',
            dataType: 'json',
            cache: false,
            success: function(data) {
                this.setState({currentIncidents: data});
            }.bind(this),
            error: function(xhr, status, err) {
                console.error(status, err.toString());
            }.bind(this)
        });
    },
    onIncidentStart: function(e) {
        e.preventDefault();
        var component = this;
        var description = React.findDOMNode(this.refs.description).value;
        $.post( "/admin/organizations/"+this.props.organizationId+"/incidents", {'description': description})
            .done(function() {
                component.fetchCurrentIncidents();
            }).fail(function() {
                alert("Cannot add an incident");
            });
    },
    onIncidentEnd: function(event) {
        var component = this;
        $.ajax(
            {
                url: "/admin/organizations/"+this.props.organizationId+"/incidents/"+this.state.currentIncidents[0].id,
                type: 'PATCH',
                data: { finish: new Date().toISOString() }
            })
            .done(function() {
                component.fetchCurrentIncidents();
            }).fail(function() {
                alert("Cannot close an incident");
            });
    },
    render: function() {
        return (
            <span>
            {
                this.state.currentIncidents.length > 0
                ?
                <button onClick={this.onIncidentEnd} className="btn btn-success">Incident closed</button>
                :
                <form onSubmit={this.onIncidentStart} className="form-inline">
                    <input ref="description" className="form-control" type="text" placeholder="Incident description"/>
                    <input type="submit" className="btn btn-danger" value="Start incident" />
                </form>
            }
            </span>
        );
    }
});

var MinutesAgo = React.createClass({
    timeSince: function (date) {
        var seconds = Math.floor((new Date() - date) / 1000);

        var interval = Math.floor(seconds / 31536000);

        if (interval > 1) {
            return interval + " years";
        }
        interval = Math.floor(seconds / 2592000);
        if (interval > 1) {
            return interval + " months";
        }
        interval = Math.floor(seconds / 86400);
        if (interval > 1) {
            return interval + " days";
        }
        interval = Math.floor(seconds / 3600);
        if (interval > 1) {
            return interval + " hours";
        }
        interval = Math.floor(seconds / 60);
        if (interval > 1) {
            return interval + " minutes";
        }
        return Math.floor(seconds) + " seconds";
    },
    render: function() {
        return (
            <span>
                {this.timeSince(this.props.date)} ago
            </span>
        );
    }
});