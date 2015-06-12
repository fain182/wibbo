var AddOrganizationForm = React.createClass({
    render: function() {
        return (
            <form action="organizations" method="post">
                Organization name: <input name="name"/>
            </form>
        );
    }
});

React.render(
    <AddOrganizationForm />,
    document.getElementById('content')
);
