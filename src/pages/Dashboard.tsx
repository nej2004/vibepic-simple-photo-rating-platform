import React, { useState } from 'react'
import { motion } from 'framer-motion'
import { Heart, Star, Palette, SkipForward, CheckCircle } from 'lucide-react'
import toast from 'react-hot-toast'

interface Photo {
  id: number
  imageUrl: string
  caption: string
  username: string
  profilePic: string
  uploadDate: string
  category: string
  socialScore: number
}

const Dashboard = () => {
  const [currentPhoto, setCurrentPhoto] = useState<Photo>({
    id: 1,
    imageUrl: 'https://images.pexels.com/photos/1040880/pexels-photo-1040880.jpeg?auto=compress&cs=tinysrgb&w=800',
    caption: 'Golden hour portrait session in the city',
    username: 'alexphoto',
    profilePic: 'https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&w=100',
    uploadDate: '2024-01-15',
    category: 'portrait',
    socialScore: 850,
  })

  const [ratings, setRatings] = useState({
    posing: 5,
    style: 5,
    creativity: 5,
    impression: 'Hot'
  })

  const [isSubmitting, setIsSubmitting] = useState(false)

  const handleSliderChange = (category: string, value: number) => {
    setRatings(prev => ({ ...prev, [category]: value }))
  }

  const handleImpressionChange = (impression: string) => {
    setRatings(prev => ({ ...prev, impression }))
  }

  const handleSubmitRating = async () => {
    setIsSubmitting(true)
    try {
      // Simulate API call
      await new Promise(resolve => setTimeout(resolve, 1000))
      toast.success('Rating submitted successfully!')
      loadNextPhoto()
    } catch (error) {
      toast.error('Failed to submit rating')
    } finally {
      setIsSubmitting(false)
    }
  }

  const loadNextPhoto = () => {
    // Simulate loading next photo
    const photos = [
      {
        id: 2,
        imageUrl: 'https://images.pexels.com/photos/1239291/pexels-photo-1239291.jpeg?auto=compress&cs=tinysrgb&w=800',
        caption: 'Fashion editorial shoot',
        username: 'fashionista',
        profilePic: 'https://images.pexels.com/photos/415829/pexels-photo-415829.jpeg?auto=compress&cs=tinysrgb&w=100',
        uploadDate: '2024-01-14',
        category: 'fashion',
        socialScore: 920,
      },
      {
        id: 3,
        imageUrl: 'https://images.pexels.com/photos/1181686/pexels-photo-1181686.jpeg?auto=compress&cs=tinysrgb&w=800',
        caption: 'Creative concept photography',
        username: 'creativemind',
        profilePic: 'https://images.pexels.com/photos/774909/pexels-photo-774909.jpeg?auto=compress&cs=tinysrgb&w=100',
        uploadDate: '2024-01-13',
        category: 'concept',
        socialScore: 780,
      }
    ]
    
    const randomPhoto = photos[Math.floor(Math.random() * photos.length)]
    setCurrentPhoto(randomPhoto)
    setRatings({ posing: 5, style: 5, creativity: 5, impression: 'Hot' })
  }

  const impressions = [
    { value: 'Hot', label: 'Hot', color: 'bg-red-500', emoji: '🔥' },
    { value: 'Elegant', label: 'Elegant', color: 'bg-purple-500', emoji: '✨' },
    { value: 'Confident', label: 'Confident', color: 'bg-green-500', emoji: '💪' },
  ]

  return (
    <div className="min-h-screen bg-gray-50 py-8">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <motion.div
          initial={{ opacity: 0, y: 20 }}
          animate={{ opacity: 1, y: 0 }}
          transition={{ duration: 0.6 }}
          className="text-center mb-8"
        >
          <h1 className="text-3xl font-bold text-gray-900 mb-2">Rate Photos</h1>
          <p className="text-gray-600">Help build the community by rating photos on posing, style, and creativity</p>
        </motion.div>

        <div className="grid lg:grid-cols-3 gap-8">
          {/* Photo Display */}
          <motion.div
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.6, delay: 0.1 }}
            className="lg:col-span-2"
          >
            <div className="photo-card">
              <div className="aspect-w-16 aspect-h-12 mb-4">
                <img
                  src={currentPhoto.imageUrl}
                  alt={currentPhoto.caption}
                  className="w-full h-96 object-cover rounded-lg"
                />
              </div>
              
              <div className="p-6">
                <div className="flex items-center space-x-3 mb-4">
                  <img
                    src={currentPhoto.profilePic}
                    alt={currentPhoto.username}
                    className="w-12 h-12 rounded-full object-cover"
                  />
                  <div>
                    <h3 className="font-semibold text-gray-900">{currentPhoto.username}</h3>
                    <p className="text-sm text-gray-500">
                      {new Date(currentPhoto.uploadDate).toLocaleDateString()} • {currentPhoto.category}
                    </p>
                  </div>
                </div>
                
                {currentPhoto.caption && (
                  <p className="text-gray-700 mb-4">{currentPhoto.caption}</p>
                )}
                
                <div className="flex items-center justify-between">
                  <span className="text-sm text-gray-500">
                    Social Score: {currentPhoto.socialScore}
                  </span>
                  <span className="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-sm font-medium">
                    {currentPhoto.category}
                  </span>
                </div>
              </div>
            </div>
          </motion.div>

          {/* Rating Panel */}
          <motion.div
            initial={{ opacity: 0, x: 20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.6, delay: 0.2 }}
            className="space-y-6"
          >
            {/* Overall Impression */}
            <div className="card">
              <h3 className="text-lg font-semibold text-gray-900 mb-4">Overall Impression</h3>
              <div className="grid grid-cols-1 gap-3">
                {impressions.map((impression) => (
                  <button
                    key={impression.value}
                    onClick={() => handleImpressionChange(impression.value)}
                    className={`p-3 rounded-lg border-2 transition-all ${
                      ratings.impression === impression.value
                        ? `${impression.color} text-white border-transparent`
                        : 'border-gray-200 hover:border-gray-300 text-gray-700'
                    }`}
                  >
                    <span className="mr-2">{impression.emoji}</span>
                    {impression.label}
                  </button>
                ))}
              </div>
            </div>

            {/* Rating Sliders */}
            <div className="card">
              <h3 className="text-lg font-semibold text-gray-900 mb-4">Detailed Ratings</h3>
              
              <div className="space-y-6">
                {/* Posing */}
                <div>
                  <div className="flex items-center justify-between mb-2">
                    <label className="flex items-center text-sm font-medium text-gray-700">
                      <Heart className="h-4 w-4 mr-1" />
                      Posing
                    </label>
                    <span className="text-sm font-semibold text-gray-900">{ratings.posing}/10</span>
                  </div>
                  <input
                    type="range"
                    min="1"
                    max="10"
                    value={ratings.posing}
                    onChange={(e) => handleSliderChange('posing', parseInt(e.target.value))}
                    className="rating-slider w-full"
                  />
                </div>

                {/* Style */}
                <div>
                  <div className="flex items-center justify-between mb-2">
                    <label className="flex items-center text-sm font-medium text-gray-700">
                      <Star className="h-4 w-4 mr-1" />
                      Style
                    </label>
                    <span className="text-sm font-semibold text-gray-900">{ratings.style}/10</span>
                  </div>
                  <input
                    type="range"
                    min="1"
                    max="10"
                    value={ratings.style}
                    onChange={(e) => handleSliderChange('style', parseInt(e.target.value))}
                    className="rating-slider w-full"
                  />
                </div>

                {/* Creativity */}
                <div>
                  <div className="flex items-center justify-between mb-2">
                    <label className="flex items-center text-sm font-medium text-gray-700">
                      <Palette className="h-4 w-4 mr-1" />
                      Creativity
                    </label>
                    <span className="text-sm font-semibold text-gray-900">{ratings.creativity}/10</span>
                  </div>
                  <input
                    type="range"
                    min="1"
                    max="10"
                    value={ratings.creativity}
                    onChange={(e) => handleSliderChange('creativity', parseInt(e.target.value))}
                    className="rating-slider w-full"
                  />
                </div>
              </div>
            </div>

            {/* Action Buttons */}
            <div className="space-y-3">
              <button
                onClick={handleSubmitRating}
                disabled={isSubmitting}
                className="w-full btn btn-primary py-3"
              >
                {isSubmitting ? (
                  <div className="flex items-center justify-center">
                    <div className="animate-spin rounded-full h-4 w-4 border-b-2 border-white mr-2" />
                    Submitting...
                  </div>
                ) : (
                  <>
                    <CheckCircle className="h-4 w-4 mr-2" />
                    Submit Rating
                  </>
                )}
              </button>
              
              <button
                onClick={loadNextPhoto}
                className="w-full btn btn-outline py-3"
              >
                <SkipForward className="h-4 w-4 mr-2" />
                Next Photo
              </button>
            </div>
          </motion.div>
        </div>
      </div>
    </div>
  )
}

export default Dashboard