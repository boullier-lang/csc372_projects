import ReviewCard from '../components/ReviewCard'
import Sidebar from '../components/sideBar'
import './reviews.css'

const fakeReviews = [
  { author: "Sarah M.", stars: 5, text: "Absolutely love this place! My hair has never looked better. Will definitely be coming back!" },
  { author: "Jessica R.", stars: 5, text: "Amazing experience from start to finish. The staff is so friendly and talented." },
  { author: "Emily T.", stars: 4, text: "Great salon, very clean and professional. Loved my balayage!" },
  { author: "Olivia K.", stars: 5, text: "Best keratin treatment I've ever had. My hair is so smooth and shiny!" },
  { author: "Amanda L.", stars: 4, text: "Really happy with my highlights. Prices are fair for the quality you get." },
  { author: "Rachel P.", stars: 5, text: "I've been coming here for years and they never disappoint. Highly recommend!" },
]

export default function Reviews() {
  return (
    <div id="main">
      <div id="left">
        <Sidebar />
      </div>
      <div id="right">
        <h2>Customer Reviews</h2>
        <div id="reviews-grid">
          {fakeReviews.map((review) => (
            <ReviewCard key={review.author} review={review} />
          ))}
        </div>
      </div>
    </div>
  )
}