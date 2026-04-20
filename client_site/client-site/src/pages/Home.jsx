import imgOne from '../assets/img_one.jpg'
import imgTwo from '../assets/img_two.jpg'
import imgThree from '../assets/img_three.jpg'
import imgFour from '../assets/img_four.jpg'
import imgFive from '../assets/img_five.jpg'
import imgSix from '../assets/img_six.jpg'

import Sidebar from '../components/sideBar'


export default function Home() {
  return (
    <div id="main">
      {/* LEFT SIDE */}
      <div id="left">
		<Sidebar />
	  </div>
		
      {/* RIGHT SIDE */}
      <div id="right">
        <div className="photo-grid">
          <img src={imgOne} alt="Hair Style 1" />
          <img src={imgTwo} alt="Hair Style 2" />
          <img src={imgThree} alt="Hair Style 3" />
          <img src={imgFour} alt="Hair Style 4" />
          <img src={imgFive} alt="Hair Style 5" />
          <img src={imgSix} alt="Hair Style 6" />
        </div>
        <button id="book-btn">BOOK NOW</button>
      </div>
    </div>
  )
}