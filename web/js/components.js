var AddOrganizationForm = React.createClass({
    handleSubmit: function(e) {
        e.preventDefault();
        var name = React.findDOMNode(this.refs.name).value;
        this.props.onFormSubmit(name);
        React.findDOMNode(this.refs.name).value = '';
    },
    render: function() {
        return (
            <form className="commentForm" onSubmit={this.handleSubmit}>
                <h1>Add an Organization</h1>
                <h3 ref="message">{this.props.message} </h3>
                Organization name: <input ref="name"/>
                <br />
                <input type="submit" value="Add" className="btn btn-primary" />
            </form>
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
                {
                    this.props.readOnly == "true"
                    ?
                    <button onClick={this.onRemove} className="btn btn-default pull-right" style={{"marginTop":"-6px"}}>
                        Remove
                    </button>
                    : null
                }
                {this.props.name}
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



