var AddOrganizationForm = React.createClass({
    getInitialState: function() {
        return {message: ''};
    },
    handleSubmit: function(e) {
        e.preventDefault();
        var name = React.findDOMNode(this.refs.name).value.trim();
        if (!name) {
            return;
        }
        var component = this;
        $.post( "/admin/organizations", {'name': name})
            .done(function() {
                component.setState({message: 'Organization added'});
                React.findDOMNode(component.refs.name).value = '';
            }).fail(function() {
                component.setState({message: 'Error'});
            });
    },
    render: function() {
        return (
            <form className="commentForm" onSubmit={this.handleSubmit}>
                <h1>Add an Organization</h1>
                <h3 ref="message">{this.state.message} </h3>
                Organization name: <input ref="name"/>
                <br />
                <input type="submit" value="Add" className="btn btn-primary" />
            </form>
        );
    }
});

React.render(
    <AddOrganizationForm />,
    document.getElementById('content')
);
