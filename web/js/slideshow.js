var Slideshow = React.createClass({
  KEY_SPACE: 32,
  KEY_RIGHT_ARROW: 39,
  intervalId: null,
  numRunningBufferFills: 0,
  getInitialState: function () {
    return {
      autoPlay: false,
      buffer: [],
      history: [{url: "#", caption: ''}],
      index: 0
    }
  },
  componentDidMount: function () {
    $(window).on('keyup', this.handleKeyPress);
  },
  handleKeyPress: function (e) {
    switch (e.keyCode) {
      case this.KEY_SPACE:
        this.toggleAutoPlay();
        break;
      case this.KEY_RIGHT_ARROW:
        this.nextImage();
        break;
      default:
        console.log("Keyode: " + e.keyCode);
        break;
    }
  },
  componentWillUnmount: function () {
    this.setAutoPlay(false);
    this.syncInterval();
  },
  syncInterval(){
    if (this.intervalId == null && this.state.autoPlay) {
      this.tick();
      this.intervalId = setInterval(this.tick, 3000);
    } else if (this.intervalId != null && !this.state.autoPlay) {
      clearInterval(this.intervalId);
      this.intervalId = null;
    }
  },
  setAutoPlay: function (active) {
    this.setState({autoPlay:active, index:0});
    this.syncInterval();
  },
  toggleAutoPlay: function () {
    this.setAutoPlay(!this.state.autoPlay);
  },
  nextImage(){
    this.setAutoPlay(false);
    this.tick();
  },
  previousImage(){
    if (this.state.history[this.state.index + 1] != undefined) {
      this.setAutoPlay(false);
      this.setState({index: this.state.index + 1});
    }
  },
  addToHistory: function (obj) {
    var history = this.state.history;
    history.unshift(obj);
    history = history.slice(0, 9);
    this.setState({history: history});
  },
  tick: function () {
    if (this.state.index == 0) {
      if(this.state.buffer.length == 0){
        this.fillBuffer();
      } else {
        var buffer = this.state.buffer;
        var current = buffer.shift();
        this.setState({buffer:buffer});
        //TODO: Bygg in addToHistory här? Används bara här?
        this.addToHistory(current);
      }
    } else {
      this.setState({index: this.state.index - 1});
    }
  },
  fillBuffer: function(){
    if((this.state.buffer.length + this.numRunningBufferFills) < 10){
      console.log("running buffer filler");
      this.numRunningBufferFills++;
      var url = '/slideshow/' + this.props.slideshowId + '/nextgif';
      $.ajax({
        dataType: "json",
        url: url,
        data: [],
        success: function (data) {
          //console.log(data);
          this.setState({buffer: this.state.buffer.concat([data])});
        }.bind(this),
        complete: function(){
          this.numRunningBufferFills--;
        }.bind(this)
      });
    }
  },
  setCurrent(obj){
    this.setState({current: obj});
  },

  render: function () {
    this.syncInterval();
    this.fillBuffer();
    var currentImage = this.state.history[this.state.index];
    return (
        <div>
          <img src={currentImage.url}/><br/>
          <div>{currentImage.caption}</div>
          <SlideShowControls
              toggleAutoPlay={this.toggleAutoPlay}
              autoPlay={this.state.autoPlay}
              handleNextImage={this.nextImage}
              handlePrevImage={this.previousImage}
          />
          <div style={{display:'none'}}>
            {this.state.buffer.map(function (obj, index) {
              return <img key={JSON.stringify(obj)} src={obj.url}/>;
            })}
          </div>
          <ul>
            {this.state.history.map(function (obj, index) {
              //console.log(index);
              var style = ((this.state.index == index) ? {fontWeight: 'bold'} : {});
              return <li style={style} key={JSON.stringify(obj)}>{obj.url} : {obj.caption}</li>;
            }.bind(this))}
          </ul>
        </div>
    );
  }
});

/**
 * Slideshow controls
 */

var SlideShowControls = React.createClass({
  render: function () {
    var autoPlayClass = this.props.autoPlay ? 'btn-success' : '';
    return (
        <div className="btn-group">
          <button type="button" className="btn" onClick={this.props.handlePrevImage}>
            <span className="glyphicon glyphicon-fast-backward"/>
          </button>
          <button type="button" className={"btn "+autoPlayClass} onClick={this.props.toggleAutoPlay}>
            <span className="glyphicon glyphicon-play"/>
          </button>
          <button type="button" className="btn" onClick={this.props.handleNextImage}>
            <span className="glyphicon glyphicon-fast-forward"/>
          </button>
        </div>
    );
  }
});

ReactDOM.render(
    <Slideshow slideshowId={slideshowId} delay={delay}/>,
    document.getElementById('app')
);





