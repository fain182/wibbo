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
    render: function() {
        return (
            <div className="well">{this.props.name}</div>
        );
    }
});

var OrganizationList = React.createClass({
    render: function() {
        var nodes = this.props.data.map(function (organization) {
            return (
                <Organization name={organization.name}/>
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

var OrganizationAdmin = React.createClass({
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
    render: function () {
        return (
            <span>
                <AddOrganizationForm onFormSubmit={this.handleSubmit} message={this.state.message}/>
                <OrganizationList data={this.state.organizations} />
            </span>
        )
    }
});


React.render(
    <OrganizationAdmin />,
    document.getElementById('content')
);
