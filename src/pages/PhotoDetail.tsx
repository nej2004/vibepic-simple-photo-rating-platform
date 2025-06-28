import React from 'react'
import { useParams } from 'react-router-dom'
import { motion } from 'framer-motion'
import { Heart, Star, Palette, Calendar, User } from 'lucide-react'

const PhotoDetail = () => {
  const { id } = useParams()

  // Mock photo data
  const photo = {
    id: 1,
    imageUrl: 'https://images.pexels.com/photos/1040880/pexels-photo-1040880.jpeg?auto=compress&cs=tinysrgb&w=1200',
    caption: 'Golden hour portrait session in the city',
    category: 'portrait',
    uploadDate: '2024-01-15',
    socialScore: 850,
    user: {
      id: 1,
      username: 'alexphoto',
      profilePic: 'https://images.pexels.com/photos/220453/pexels-photo-220453.jpeg?auto=compress&cs=tinysrgb&w=100',
    },
    ratings: [
      {
        id: 1,
        rater: 'fashionista',
        posing: 9,
        style: 8,
        creativity: 9,
        impression: 'Confident',
        date: '2024-01-16',
      },
      {
        id: 2,
        rater: 'creativemind',
        posing: 8,
        style: 9,
        creativity: 8,
        impression: 'Elegant',
        date: '2024-01-16',
      },
      {
        id: 3,
        rater: 'photoexpert',
        posing: 9,
        style: 8,
        creativity: 9,
        impression: 'Hot',
        date: '2024-01-15',
      },
    ],
    avgRatings: {
      posing: 8.7,
      style: 8.3,
      creativity: 8.7,
    },
  }

  const getImpressionColor = (impression: string) => {
    switch (impression) {
      case 'Hot':
        return 'bg-red-100 text-red-800'
      case 'Elegant':
        return 'bg-purple-100 text-purple-800'
      case 'Confident':
        return 'bg-green-100 text-green-800'
      default:
        return 'bg-gray-100 text-gray-800'
    }
  }

  return (
    <div className="min-h-screen bg-gray-50 py-8">
      <div className="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="grid lg:grid-cols-3 gap-8">
          {/* Photo Display */}
          <motion.div
            initial={{ opacity: 0, x: -20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.6 }}
            className="lg:col-span-2"
          >
            <div className="card">
              <img
                src={photo.imageUrl}
                alt={photo.caption}
                className="w-full h-96 lg:h-[600px] object-cover rounded-lg mb-6"
              />
              
              <div className="space-y-4">
                <div className="flex items-center space-x-3">
                  <img
                    src={photo.user.profilePic}
                    alt={photo.user.username}
                    className="w-12 h-12 rounded-full object-cover"
                  />
                  <div>
                    <h3 className="font-semibold text-gray-900">{photo.user.username}</h3>
                    <p className="text-sm text-gray-500">
                      {new Date(photo.uploadDate).toLocaleDateString()}
                    </p>
                  </div>
                </div>
                
                <h1 className="text-2xl font-bold text-gray-900">{photo.caption}</h1>
                
                <div className="flex items-center space-x-4">
                  <span className="px-3 py-1 bg-primary-100 text-primary-800 rounded-full text-sm font-medium">
                    {photo.category}
                  </span>
                  <span className="text-sm text-gray-600">
                    Social Score: {photo.socialScore}
                  </span>
                </div>
              </div>
            </div>
          </motion.div>

          {/* Ratings Panel */}
          <motion.div
            initial={{ opacity: 0, x: 20 }}
            animate={{ opacity: 1, x: 0 }}
            transition={{ duration: 0.6, delay: 0.1 }}
            className="space-y-6"
          >
            {/* Average Ratings */}
            <div className="card">
              <h3 className="text-lg font-semibold text-gray-900 mb-4">Average Ratings</h3>
              
              <div className="space-y-4">
                <div>
                  <div className="flex items-center justify-between mb-2">
                    <div className="flex items-center">
                      <Heart className="h-4 w-4 text-red-500 mr-2" />
                      <span className="text-sm font-medium">Posing</span>
                    </div>
                    <span className="text-sm font-semibold">{photo.avgRatings.posing}/10</span>
                  </div>
                  <div className="w-full bg-gray-200 rounded-full h-2">
                    <div
                      className="bg-red-500 h-2 rounded-full"
                      style={{ width: `${(photo.avgRatings.posing / 10) * 100}%` }}
                    />
                  </div>
                </div>

                <div>
                  <div className="flex items-center justify-between mb-2">
                    <div className="flex items-center">
                      <Star className="h-4 w-4 text-blue-500 mr-2" />
                      <span className="text-sm font-medium">Style</span>
                    </div>
                    <span className="text-sm font-semibold">{photo.avgRatings.style}/10</span>
                  </div>
                  <div className="w-full bg-gray-200 rounded-full h-2">
                    <div
                      className="bg-blue-500 h-2 rounded-full"
                      style={{ width: `${(photo.avgRatings.style / 10) * 100}%` }}
                    />
                  </div>
                </div>

                <div>
                  <div className="flex items-center justify-between mb-2">
                    <div className="flex items-center">
                      <Palette className="h-4 w-4 text-green-500 mr-2" />
                      <span className="text-sm font-medium">Creativity</span>
                    </div>
                    <span className="text-sm font-semibold">{photo.avgRatings.creativity}/10</span>
                  </div>
                  <div className="w-full bg-gray-200 rounded-full h-2">
                    <div
                      className="bg-green-500 h-2 rounded-full"
                      style={{ width: `${(photo.avgRatings.creativity / 10) * 100}%` }}
                    />
                  </div>
                </div>
              </div>
            </div>

            {/* Individual Ratings */}
            <div className="card">
              <h3 className="text-lg font-semibold text-gray-900 mb-4">
                Ratings ({photo.ratings.length})
              </h3>
              
              <div className="space-y-4 max-h-96 overflow-y-auto">
                {photo.ratings.map((rating) => (
                  <div key={rating.id} className="border-b border-gray-200 pb-4 last:border-b-0">
                    <div className="flex items-center justify-between mb-2">
                      <div className="flex items-center">
                        <User className="h-4 w-4 text-gray-400 mr-2" />
                        <span className="text-sm font-medium text-gray-900">{rating.rater}</span>
                      </div>
                      <span className="text-xs text-gray-500">
                        {new Date(rating.date).toLocaleDateString()}
                      </span>
                    </div>
                    
                    <div className="grid grid-cols-3 gap-2 text-xs mb-2">
                      <div className="text-center">
                        <div className="font-medium">Posing</div>
                        <div className="text-gray-600">{rating.posing}/10</div>
                      </div>
                      <div className="text-center">
                        <div className="font-medium">Style</div>
                        <div className="text-gray-600">{rating.style}/10</div>
                      </div>
                      <div className="text-center">
                        <div className="font-medium">Creativity</div>
                        <div className="text-gray-600">{rating.creativity}/10</div>
                      </div>
                    </div>
                    
                    <span className={`inline-block px-2 py-1 rounded-full text-xs font-medium ${getImpressionColor(rating.impression)}`}>
                      {rating.impression}
                    </span>
                  </div>
                ))}
              </div>
            </div>
          </motion.div>
        </div>
      </div>
    </div>
  )
}

export default PhotoDetail