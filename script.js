// A little enhanced of Facebook's React TODO example.
// Want to be looked Reminder alike.

class TodoApp extends React.Component {
  constructor(props) {
    super(props);

    this.state = {
      items: [],
      text: "" };


    this.handleTextChange = this.handleTextChange.bind(this);
    this.handleAddItem = this.handleAddItem.bind(this);
    this.markItemCompleted = this.markItemCompleted.bind(this);
    this.handleDeleteItem = this.handleDeleteItem.bind(this);
  }
  handleTextChange(event) {
    this.setState({
      text: event.target.value });

  }
  handleAddItem(event) {
    event.preventDefault();

    var newItem = {
      id: Date.now(),
      text: this.state.text,
      done: false };


    this.setState(prevState => ({
      items: prevState.items.concat(newItem),
      text: "" }));

  }
  markItemCompleted(itemId) {
    var updatedItems = this.state.items.map(item => {
      if (itemId === item.id)
      item.done = !item.done;

      return item;
    });

    // State Updates are Merged
    this.setState({
      items: [].concat(updatedItems) });

  }
  handleDeleteItem(itemId) {
    var updatedItems = this.state.items.filter(item => {
      return item.id !== itemId;
    });

    this.setState({
      items: [].concat(updatedItems) });

  }
  render() {
    return (
      React.createElement("div", null,
      React.createElement("h3", { className: "apptitle" }, "MY TO DO LIST"),
      React.createElement("div", { className: "row" },
      React.createElement("div", { className: "col-md-3" },
      React.createElement(TodoList, { items: this.state.items, onItemCompleted: this.markItemCompleted, onDeleteItem: this.handleDeleteItem }))),


      React.createElement("form", { className: "row" },
      React.createElement("div", { className: "col-md-3" },
      React.createElement("input", { type: "text", className: "form-control", onChange: this.handleTextChange, value: this.state.text })),

      React.createElement("div", { className: "col-md-3" },
      React.createElement("button", { className: "btn btn-primary", onClick: this.handleAddItem, disabled: !this.state.text }, "Add #" + (this.state.items.length + 1))))));




  }}


class TodoItem extends React.Component {
  constructor(props) {
    super(props);
    this.markCompleted = this.markCompleted.bind(this);
    this.deleteItem = this.deleteItem.bind(this);
  }
  markCompleted(event) {
    this.props.onItemCompleted(this.props.id);
  }
  deleteItem(event) {
    this.props.onDeleteItem(this.props.id);
  }
  // Highlight newly added item for several seconds.
  componentDidMount() {
    if (this._listItem) {
      // 1. Add highlight class.
      this._listItem.classList.add("highlight");

      // 2. Set timeout.
      setTimeout(listItem => {
        // 3. Remove highlight class.
        listItem.classList.remove("highlight");
      }, 500, this._listItem);
    }
  }
  render() {
    var itemClass = "form-check todoitem " + (this.props.completed ? "done" : "undone");
    return (
      React.createElement("td.task", { className: itemClass, ref: li => this._listItem = li },
      React.createElement("label", { className: "form-check-label" },
      React.createElement("input", { type: "checkbox", className: "form-check-input", onChange: this.markCompleted }), " ", this.props.text),

      React.createElement("button", { type: "button", className: "btn btn-danger btn-sm", onClick: this.deleteItem }, "x")));


  }}


class TodoList extends React.Component {
  render() {
    return (
      React.createElement("ul", { className: "todolist" },
      this.props.items.map((item) =>
      React.createElement(TodoItem, { key: item.id, id: item.id, text: item.text, completed: item.done, onItemCompleted: this.props.onItemCompleted, onDeleteItem: this.props.onDeleteItem }))));



  }}


ReactDOM.render(React.createElement(TodoApp, null), document.getElementById("app"));