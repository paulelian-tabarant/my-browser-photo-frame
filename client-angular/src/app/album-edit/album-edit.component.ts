import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { PhotosManagerService, AlbumInfo } from '../photos-manager.service';

@Component({
  selector: 'app-album-edit',
  templateUrl: './album-edit.component.html',
  styleUrls: ['./album-edit.component.less']
})
export class AlbumEditComponent implements OnInit {

  albumName: string;
  albumDescription: string;
  photosList: string[];

  constructor(private route: ActivatedRoute,
              private photosManagerService: PhotosManagerService) { }

  ngOnInit() {
    this.albumName = this.route.snapshot.paramMap.get('name');
    
    this.photosManagerService.getAlbumInfo(this.albumName)
      .then((albumInfo: AlbumInfo) => { this.albumDescription = albumInfo.description; })
      .catch( /* do things here if necessary */ );

    this.photosManagerService.getPhotosList(this.albumName)
      .then((photosList: string[]) => { this.photosList = photosList; })
      .catch( /* do things here if necessary */);
  }

}
