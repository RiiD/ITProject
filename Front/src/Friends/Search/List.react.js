/** @jsx React.DOM */

var List = React.createClass({
    render: function(){
        return (
            <ul>
                {
                    this.props.items.map(function(item) {
                        return <li key={item}>{item}</li>
                    })
                }
            </ul>
        )
    }
});

var FilteredList = React.createClass({
    filterList: function(event){
        var updatedList = this.state.initialItems;
        updatedList = updatedList.filter(function(item){
            return item.toLowerCase().search(event.target.value.toLowerCase()) !== -1;
        });
        this.setState({items: updatedList});
    },
    
    addToList : function(event){
        var updated = this.state.initialItems;
        updated.push(document.getElementById("1").value);
        this.setState({initialItems : updated});
    },
    
    getInitialState: function(){
        return {
            initialItems: [
                "item1",
                "user",
                "test"
            ],
            items: []
        }
    },
    componentWillMount: function(){
        this.setState({items: this.state.initialItems})
    },
    render: function(){
        return (
            <div className="filter-list">
                <input type="text" id = "1" placeholder="Search" onChange={this.filterList} />

                <List items={this.state.items}/>
                <input  type = "button" value = "add to list" onClick = {this.addToList}></input>
            </div>
        );
    }
});

React.renderComponent(<FilteredList/>, document.getElementById('mount-point'));