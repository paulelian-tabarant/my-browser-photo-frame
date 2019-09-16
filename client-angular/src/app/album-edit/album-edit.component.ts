import { Component, OnInit } from '@angular/core';
import { ActivatedRoute } from '@angular/router';
import { PhotosManagerService, AlbumInfo } from '../photos-manager.service';
import { FileUploader } from 'ng2-file-upload';

import { Config } from '../config';

const uploadUrl = Config.apiUrl + '/uploadPhoto';

@Component({
  selector: 'app-album-edit',
  templateUrl: './album-edit.component.html',
  styleUrls: ['./album-edit.component.less']
})
export class AlbumEditComponent implements OnInit {

  private imageFieldName: string = "photo";

  albumName: string;
  albumDescription: string;
  photosList: string[];
  
  uploader: FileUploader;
  response: string;

  constructor(private route: ActivatedRoute,
              private photosManagerService: PhotosManagerService) { }


  private loadAlbumContent(name: string) {
    this.photosManagerService.getPhotosList(this.albumName)
      .then((photosList: string[]) => { this.photosList = photosList; })
      .catch( /* do things here if necessary */);
  }

  ngOnInit() {
    this.albumName = this.route.snapshot.paramMap.get('name');
    
    this.photosManagerService.getAlbumInfo(this.albumName)
      .then((albumInfo: AlbumInfo) => { this.albumDescription = albumInfo.description; })
      .catch( /* do things here if necessary */ );

    this.loadAlbumContent(this.albumName);

    this.uploader = new FileUploader({
      url: uploadUrl,
      method: "POST",
      itemAlias: this.imageFieldName,
      additionalParameter: {
        'album': this.albumName
      },
    });

    this.uploader.response.subscribe(() => {
      this.loadAlbumContent(this.albumName)
    });
  }

  deletePhoto(srcPath: string) {
    this.photosManagerService.deletePhoto(srcPath)
      .then(() => {
        alert('Photo correctement supprimée.');
        this.loadAlbumContent(this.albumName)
      })
      .catch(() => alert);
  }

}
